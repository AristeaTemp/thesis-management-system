<?php
// API endpoint για λήψη ιστορικού ενεργειών διπλωματικής εργασίας
// Εμφανίζει όλες τις αλλαγές κατάστασης και ενέργειες

// Έναρξη session για έλεγχο ταυτοποίησης
session_start();

// Ορισμός content type ως JSON
header('Content-Type: application/json; charset=utf-8');

// Έλεγχος ότι ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit(json_encode([]));
}

if (!isset($_GET['thesis_id'])) {
    http_response_code(400);
    exit(json_encode([]));
}

$thesis_id = $_GET['thesis_id'];

require_once "../../config.php";
$conn = getDBConnection();
$conn->set_charset("utf8");

$stmt = $conn->prepare("SELECT new_status, change_timestamp FROM thesis_status_history WHERE thesis_id = ? ORDER BY change_timestamp ASC");
$stmt->bind_param("i", $thesis_id);
$stmt->execute();
$result = $stmt->get_result();
$history = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($history);

$stmt->close();
$conn->close();
?>