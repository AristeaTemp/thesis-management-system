<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    http_response_code(401);
    echo json_encode([]);
    exit();
}

$professor_id = $_SESSION['user_id'];
require_once "../../config.php";
$conn = getDBConnection();
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([]);
    exit();
}

// SQL Query για θέματα που:
// 1. Έχουν κατάσταση 'under_assignment'
// 2. Δεν έχουν ανατεθεί σε φοιτητή (student_id IS NULL)
// 3. Ανήκουν στον συνδεδεμένο καθηγητή (supervisor_id = ?)
$stmt = $conn->prepare("
    SELECT id, title 
    FROM theses
    WHERE status = 'under_assignment'
      AND student_id IS NULL 
      AND supervisor_id = ? 
");
$stmt->bind_param("i", $professor_id);
$stmt->execute();
$result = $stmt->get_result();

$topics = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

echo json_encode($topics);
?>