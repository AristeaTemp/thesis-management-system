<?php
// Έναρξη συνεδρίας και ρύθμιση κεφαλίδων απόκρισης
session_start();
header('Content-Type: application/json');

// Έλεγχος εξουσιοδότησης - μόνο φοιτητές έχουν πρόσβαση στο προφίλ τους
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    echo json_encode(['error' => 'Δεν επιτρέπεται η πρόσβαση.']);
    exit;
}

// Λήψη ID φοιτητή από τη συνεδρία
$user_id = $_SESSION['user_id'];

// Σύνδεση στη βάση δεδομένων
require_once "../../config.php";
$conn = getDBConnection();

// Έλεγχος σύνδεσης με τη βάση δεδομένων
if ($conn->connect_error) {
    echo json_encode(['error' => 'Σφάλμα σύνδεσης στη βάση δεδομένων.']);
    exit;
}

// Ανάκτηση στοιχείων φοιτητή και email από τους πίνακες students και users
$stmt = $conn->prepare("
    SELECT s.*, u.email 
    FROM students s
    JOIN users u ON s.user_id = u.id
    WHERE s.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($profile = $result->fetch_assoc()) {
    echo json_encode($profile);
} else {
    echo json_encode(['error' => 'Δεν βρέθηκε το προφίλ.']);
}

$stmt->close();
$conn->close();
?>
