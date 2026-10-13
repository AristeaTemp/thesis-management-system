<?php
// API endpoint για λήψη στατιστικών καθηγητή
// Εμφανίζει πλήθος διπλωματικών εργασιών ανά κατάσταση

// Απενεργοποίηση warnings που θα χαλούσαν το JSON output
error_reporting(0);
ini_set('display_errors', 0);

// Έναρξη session για έλεγχο ταυτοποίησης
session_start();

// Ορισμός content type ως JSON
header('Content-Type: application/json; charset=utf-8');

// Έλεγχος ότι ο χρήστης είναι συνδεδεμένος και είναι καθηγητής
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized access."]);
    exit();
}

// Λήψη ID καθηγητή από το session
$professor_id = $_SESSION['user_id'];

// Σύνδεση στη βάση δεδομένων
require_once "../../config.php";
$conn = getDBConnection();
$conn->set_charset("utf8mb4");

// Έλεγχος σύνδεσης στη βάση
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit();
}

// Βοηθητική συνάρτηση για λήψη μίας τιμής από τη βάση
function getSingleValue($conn, $sql, $params, $types) {
    $stmt = $conn->prepare($sql);
    if (!$stmt) return 0;

    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    
    if (is_null($result) || empty($result)) {
        return 0;
    }
    // Επιστροφή της πρώτης τιμής του αποτελέσματος, ή 0 αν είναι null
    return $result[array_key_first($result)] ?? 0;
}

// Αρχικοποίηση στατιστικών με προεπιλεγμένες μηδενικές τιμές
$stats = [
    'avg_time_supervisor' => 0,      // Μέσος χρόνος ως επιβλέπων (μήνες)
    'avg_time_member' => 0,          // Μέσος χρόνος ως μέλος επιτροπής (μήνες)
    'avg_grade_supervisor' => 0.0,   // Μέσος βαθμός ως επιβλέπων
    'avg_grade_member' => 0.0,       // Μέσος βαθμός ως μέλος επιτροπής
    'total_supervisor' => 0,         // Συνολικός αριθμός ως επιβλέπων
    'total_member' => 0              // Συνολικός αριθμός ως μέλος επιτροπής
];

try {
    // Υπολογισμός συνολικού αριθμού διπλωματικών ως επιβλέπων
    $stats['total_supervisor'] = (int)getSingleValue($conn, "SELECT COUNT(id) FROM thesis_committee WHERE professor_id = ? AND role = 'supervisor'", [$professor_id], "i");
    
    // Υπολογισμός συνολικού αριθμού διπλωματικών ως μέλος επιτροπής
    $stats['total_member'] = (int)getSingleValue($conn, "SELECT COUNT(id) FROM thesis_committee WHERE professor_id = ? AND role = 'member'", [$professor_id], "i");

    // Υπολογισμός μέσου βαθμού ως επιβλέπων
    $avg_grade_supervisor = getSingleValue($conn, "SELECT AVG(t.final_grade) FROM theses t JOIN thesis_committee tc ON t.id = tc.thesis_id WHERE tc.professor_id = ? AND tc.role = 'supervisor' AND tc.invitation_status IN ('accepted', 'cancelled') AND t.status = 'completed' AND t.final_grade IS NOT NULL", [$professor_id], "i");
    $stats['avg_grade_supervisor'] = round((float)$avg_grade_supervisor, 2);

    // Υπολογισμός μέσου βαθμού ως μέλος επιτροπής
    $avg_grade_member = getSingleValue($conn, "SELECT AVG(t.final_grade) FROM theses t JOIN thesis_committee tc ON t.id = tc.thesis_id WHERE tc.professor_id = ? AND tc.role = 'member' AND tc.invitation_status IN ('accepted', 'cancelled') AND t.status = 'completed' AND t.final_grade IS NOT NULL", [$professor_id], "i");
    $stats['avg_grade_member'] = round((float)$avg_grade_member, 2);

    // Υπολογισμός μέσου χρόνου ολοκλήρωσης ως επιβλέπων (σε μήνες)
    $avg_days_supervisor = getSingleValue($conn, "SELECT AVG(DATEDIFF(t.completion_date, t.assignment_date)) FROM theses t JOIN thesis_committee tc ON t.id = tc.thesis_id WHERE tc.professor_id = ? AND tc.role = 'supervisor' AND tc.invitation_status IN ('accepted', 'cancelled') AND t.status = 'completed' AND t.assignment_date IS NOT NULL AND t.completion_date IS NOT NULL", [$professor_id], "i");
    $stats['avg_time_supervisor'] = (int)round((float)$avg_days_supervisor / 30);

    // Υπολογισμός μέσου χρόνου ολοκλήρωσης ως μέλος επιτροπής (σε μήνες)
    $avg_days_member = getSingleValue($conn, "SELECT AVG(DATEDIFF(t.completion_date, t.assignment_date)) FROM theses t JOIN thesis_committee tc ON t.id = tc.thesis_id WHERE tc.professor_id = ? AND tc.role = 'member' AND tc.invitation_status IN ('accepted', 'cancelled') AND t.status = 'completed' AND t.assignment_date IS NOT NULL AND t.completion_date IS NOT NULL", [$professor_id], "i");
    $stats['avg_time_member'] = (int)round((float)$avg_days_member / 30);

} catch (Exception $e) {
  }

// Κλείσιμο σύνδεσης με τη βάση
$conn->close();

// Εξαγωγή στατιστικών σε JSON μορφή
echo json_encode($stats);

?>