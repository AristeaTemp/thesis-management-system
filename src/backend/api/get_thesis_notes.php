<?php
// API endpoint για λήψη σχολίων διπλωματικής εργασίας
// Εμφανίζει τα σχόλια που έχει κάνει ο καθηγητής

// Έναρξη session για έλεγχο ταυτοποίησης
session_start();

// Ορισμός content type ως JSON
header('Content-Type: application/json; charset=utf-8');

// Έλεγχος ότι ο χρήστης είναι συνδεδεμένος και είναι καθηγητής
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    http_response_code(401);
    exit(json_encode([]));
}

$thesis_id = $_GET['thesis_id'] ?? 0;
$professor_id = $_SESSION['user_id'];

if (empty($thesis_id)) {
    http_response_code(400);
    exit(json_encode([]));
}

require_once "../../config.php";
$conn = getDBConnection();
$conn->set_charset("utf8");

$stmt = $conn->prepare("SELECT note_text, created_at FROM thesis_notes WHERE thesis_id = ? AND professor_id = ? ORDER BY created_at DESC");
$stmt->bind_param("ii", $thesis_id, $professor_id);
$stmt->execute();
$result = $stmt->get_result();
$notes = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($notes);

$stmt->close();
$conn->close();
?>