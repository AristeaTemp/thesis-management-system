<?php
// API endpoint για λήψη λεπτομερειών διπλωματικής εργασίας
session_start();
header('Content-Type: application/json; charset=utf-8');

// Έλεγχος δικαιωμάτων πρόσβασης (μόνο γραμματεία και καθηγητές)
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'secretary' && $_SESSION['role'] !== 'professor')) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized access."]);
    exit();
}

// Έλεγχος ύπαρξης ID διπλωματικής
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Thesis ID is missing."]);
    exit();
}

$thesis_id = $_GET['id'];
$current_user_id = $_SESSION['user_id'];
$current_role = $_SESSION['role'];

// Σύνδεση με τη βάση δεδομένων
require_once "../../config.php";
$conn = getDBConnection();
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit();
}
$conn->set_charset("utf8");

// Query για ανάκτηση βασικών λεπτομερειών διπλωματικής και απαντήσεων επιτροπής
$stmt = $conn->prepare("
    SELECT
        t.id as thesis_id, t.title, t.description, t.status, t.gs_number,
        t.final_grade, t.nimertis_link, t.assignment_date, t.draft_file_path, t.final_text_link,
        CONCAT(s.name, ' ', s.surname) as student_name,
        GROUP_CONCAT(
            DISTINCT CONCAT(
                CONCAT(p.name, ' ', p.surname), '|',
                tc.role, '|',
                tc.invitation_status, '|',
                IFNULL(DATE_FORMAT(tc.response_date, '%d/%m/%Y'), '')
            )
            SEPARATOR ';;'
        ) as committee_details
    FROM theses t
    LEFT JOIN students s ON t.student_id = s.user_id
    LEFT JOIN thesis_committee tc ON t.id = tc.thesis_id
    LEFT JOIN professors p ON tc.professor_id = p.user_id
    WHERE t.id = ?
    GROUP BY t.id, t.title, t.description, t.status, t.gs_number,
             t.final_grade, t.nimertis_link, t.assignment_date, t.draft_file_path, t.final_text_link,
             s.name, s.surname
");
$stmt->bind_param("i", $thesis_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $thesis = $result->fetch_assoc();

    //QUERY ΓΙΑ ΤΗΝ ΕΠΙΤΡΟΠΗ ΔΙΠΛΩΜΑΤΙΚΗΣ 
    // Εμφανίζουμε τον επιβλέποντα και όλα τα μέλη της επιτροπής
    $committee = [];
    $stmt_committee = $conn->prepare("
        SELECT p.name, p.surname, tc.role, tc.grade, tc.professor_id,
               tc.invitation_status
        FROM thesis_committee tc
        JOIN professors p ON tc.professor_id = p.user_id
        WHERE tc.thesis_id = ?
        ORDER BY FIELD(tc.role, 'supervisor', 'member')
    ");
    $stmt_committee->bind_param("i", $thesis_id);
    $stmt_committee->execute();
    $committee_result = $stmt_committee->get_result();
    while($row = $committee_result->fetch_assoc()) {
        $committee[] = $row;
    }
    $thesis['committee'] = $committee;
    
    // Δημιουργία string για την εμφάνιση της επιτροπής στο frontend
    $committee_members = [];
    foreach($committee as $member) {
        $role_text = ($member['role'] === 'supervisor') ? 'Επιβλέπων' : 'Μέλος';
        $committee_members[] = $member['name'] . ' ' . $member['surname'] . ' (' . $role_text . ')';
    }
    $thesis['committee_members'] = implode(', ', $committee_members);
    
    $stmt_committee->close();

    // Έλεγχος ρόλων και δικαιωμάτων του τρέχοντος χρήστη
    $is_supervisor = false;
    $is_member = false;
    $current_user_has_graded = false;
    if ($current_role === 'professor') {
        foreach($committee as $member) {
            if ($member['professor_id'] == $current_user_id) {
                $is_member = true;
                if ($member['role'] === 'supervisor') $is_supervisor = true;
                if ($member['grade'] !== null) $current_user_has_graded = true;
                break;
            }
        }
    }
    $thesis['is_supervisor'] = $is_supervisor;
    $thesis['is_member'] = $is_member;
    $thesis['current_user_has_graded'] = $current_user_has_graded;
    
    echo json_encode($thesis);
} else {
    echo json_encode(null);
}

$stmt->close();
$conn->close();
?>