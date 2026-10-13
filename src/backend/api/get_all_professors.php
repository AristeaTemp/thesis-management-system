<?php
// API endpoint για λήψη λίστας όλων των καθηγητών
// Χρησιμοποιείται για την επιλογή επιτροπής διπλωματικής εργασίας

// Έναρξη session για έλεγχο ταυτοποίησης
session_start();

// Ορισμός content type ως JSON
header('Content-Type: application/json');

// Έλεγχος ότι ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

// Φόρτωση ρυθμίσεων βάσης δεδομένων
require_once "../../config.php";
$conn = getDBConnection();

if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$result = $conn->query("SELECT user_id, name, surname FROM professors ORDER BY surname, name");

$professors = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $professors[] = $row;
    }
}

echo json_encode($professors);

$conn->close();
?>
