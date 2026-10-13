<?php
// API endpoint για λήψη προσκλήσεων τριμελούς επιτροπής
// Επιστρέφει λίστα με τις pending προσκλήσεις του συνδεδεμένου καθηγητή

session_start();
header('Content-Type: application/json; charset=utf-8');

// Έλεγχος ταυτοποίησης - μόνο καθηγητές μπορούν να δουν προσκλήσεις
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    http_response_code(401);
    exit(json_encode(["error" => "Unauthorized access."]));
}

$professor_id = $_SESSION['user_id'];
require_once "../../config.php";
$conn = getDBConnection();
$conn->set_charset("utf8");

// SQL Query για λήψη προσκλήσεων με λεπτομέρειες διπλωματικής και φοιτητή
$stmt = $conn->prepare("
    SELECT
        tc.thesis_id,
        tc.professor_id,
        t.title AS thesis_title,
        CONCAT(s.name, ' ', s.surname) AS student_name,
        (SELECT CONCAT(p.name, ' ', p.surname)
         FROM professors p
         JOIN thesis_committee sc ON p.user_id = sc.professor_id
         WHERE sc.thesis_id = tc.thesis_id AND sc.role = 'supervisor') AS supervisor_name
    FROM thesis_committee tc
    JOIN theses t ON tc.thesis_id = t.id
    JOIN students s ON t.student_id = s.user_id
    WHERE tc.professor_id = ? AND tc.invitation_status = 'pending'
");

$stmt->bind_param("i", $professor_id);
$stmt->execute();
$result = $stmt->get_result();

// Λήψη όλων των προσκλήσεων ως associative array
$invitations = $result->fetch_all(MYSQLI_ASSOC);

// Επιστροφή αποτελεσμάτων ως JSON
echo json_encode($invitations);
?>