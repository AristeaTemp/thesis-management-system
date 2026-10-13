<?php
// API endpoint για λήψη λίστας θεμάτων που έχει δημιουργήσει ο συνδεδεμένος καθηγητής
// Επιστρέφει JSON με τα θέματα που είναι σε κατάσταση "under_assignment"

// Έναρξη session για έλεγχο ταυτοποίησης
session_start();

// Ορισμός content type ως JSON
header('Content-Type: application/json');

// Έλεγχος ότι ο χρήστης είναι συνδεδεμένος και είναι καθηγητής
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized access."]);
    exit();
}

// Λήψη ID του συνδεδεμένου καθηγητή
$professor_id = $_SESSION['user_id'];

// Φόρτωση ρυθμίσεων βάσης δεδομένων
require_once "../../config.php";
$conn = getDBConnection();

// Έλεγχος σύνδεσης με τη βάση δεδομένων
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Σφάλμα σύνδεσης στη βάση δεδομένων."]);
    exit();
}
$conn->set_charset("utf8");

// Query για λήψη μόνο των θεμάτων που έχει δημιουργήσει ο συνδεδεμένος καθηγητής
$sql_topics = "SELECT id, title FROM theses WHERE status = 'under_assignment' AND supervisor_id = ?";
$stmt = $conn->prepare($sql_topics);
$stmt->bind_param("i", $professor_id);
$stmt->execute();
$result = $stmt->get_result();

// Δημιουργία πίνακα με τα θέματα
$topics = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $topics[] = $row;
    }
}

// Κλείσιμο prepared statement και σύνδεσης
$stmt->close();
$conn->close();

// Επιστροφή αποτελεσμάτων σε JSON format
echo json_encode($topics);
?>