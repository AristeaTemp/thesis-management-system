<?php
// Έναρξη συνεδρίας και ρύθμιση κεφαλίδων απόκρισης
session_start();
header('Content-Type: application/json; charset=utf-8');

// Έλεγχος εξουσιοδότησης - μόνο φοιτητές έχουν πρόσβαση
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    http_response_code(401);
    echo json_encode(['error' => 'Μη εξουσιοδοτημένη πρόσβαση.']);
    exit();
}

// Λήψη ID φοιτητή από τη συνεδρία και σύνδεση στη βάση
$student_id = $_SESSION['user_id'];
require_once "../../config.php";
$conn = getDBConnection();
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed.']);
    exit();
}
$conn->set_charset("utf8");

// Ανάκτηση βασικών στοιχείων διπλωματικής εργασίας του φοιτητή
$stmt = $conn->prepare("SELECT id, title, description, status, assignment_date, final_text_link, draft_file_path, presentation_date, presentation_time, presentation_location, material_links, nimertis_link FROM theses WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

// Έλεγχος αν υπάρχει ανατεθειμένη διπλωματική
if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Δεν σας έχει ανατεθεί διπλωματική εργασία ακόμη.']);
} else {
    // Λήψη στοιχείων διπλωματικής
    $thesis = $result->fetch_assoc();
    $thesis_id = $thesis['id'];

    // Παίρνουμε ΟΛΑ τα μέλη και την κατάσταση της πρόσκλησής τους
    $stmt_committee = $conn->prepare("
        SELECT 
            p.name, 
            p.surname, 
            tc.role, 
            tc.invitation_status,
            DATE_FORMAT(tc.response_date, '%d/%m/%Y') as response_date
        FROM thesis_committee tc
        JOIN professors p ON tc.professor_id = p.user_id
        WHERE tc.thesis_id = ?
        ORDER BY FIELD(tc.role, 'supervisor', 'member')
    ");
    $stmt_committee->bind_param("i", $thesis_id);
    $stmt_committee->execute();
    $committee_result = $stmt_committee->get_result();

    $thesis['committee'] = $committee_result->fetch_all(MYSQLI_ASSOC);
    
    echo json_encode($thesis);

    $stmt_committee->close();
}

$stmt->close();
$conn->close();
?>