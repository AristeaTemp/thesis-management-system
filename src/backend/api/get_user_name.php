<?php
// API endpoint για λήψη ονόματος συνδεδεμένου χρήστη
// Επιστρέφει το όνομα και επώνυμο του χρήστη

// Έναρξη session για έλεγχο ταυτοποίησης
session_start();

// Ορισμός content type ως JSON
header('Content-Type: application/json');

// Έλεγχος ότι ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized access."]);
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

require_once "../../config.php";
$conn = getDBConnection();

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit();
}

$user_data = [];
$table_name = ($role === 'student') ? 'students' : (($role === 'professor') ? 'professors' : 'secretaries');

$stmt = $conn->prepare("SELECT name, surname FROM $table_name WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_data['name'] = $row['name'] . ' ' . $row['surname'];
}

$stmt->close();
$conn->close();

echo json_encode($user_data);
?>