<?php
// API endpoint για λήψη λεπτομερειών συγκεκριμένου θέματος διπλωματικής εργασίας
// Επιστρέφει JSON με τα στοιχεία του θέματος για επεξεργασία

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

// Έλεγχος αν δόθηκε ID θέματος
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Topic ID is missing."]);
    exit();
}

// Λήψη ID θέματος
$topic_id = $_GET['id'];
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

// Query για λήψη λεπτομερειών θέματος (μόνο θέματα που έχει δημιουργήσει ο καθηγητής)
$sql_topic = "SELECT id, title, description, final_text_link FROM theses WHERE id = ? AND supervisor_id = ? AND status = 'under_assignment'";
$stmt = $conn->prepare($sql_topic);
$stmt->bind_param("ii", $topic_id, $professor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $topic = $result->fetch_assoc();
    echo json_encode($topic);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Δεν βρέθηκε θέμα με αυτό το ID ή δεν έχετε δικαίωμα επεξεργασίας."]);
}

// Κλείσιμο prepared statement και σύνδεσης
$stmt->close();
$conn->close();
?>