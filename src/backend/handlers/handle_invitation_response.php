<?php
// Handler για επεξεργασία απαντήσεων προσκλήσεων τριμελούς επιτροπής
// Επιτρέπει στον καθηγητή να αποδεχθεί ή να απορρίψει προσκλήσεις

session_start();
header('Content-Type: application/json');

// Έλεγχος ταυτοποίησης - μόνο καθηγητές μπορούν να απαντήσουν
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    http_response_code(401);
    exit(json_encode(["success" => false, "message" => "Unauthorized"]));
}

$current_professor_id = $_SESSION['user_id'];
// Λήψη δεδομένων από τη φόρμα
$thesis_id = $_POST['thesis_id'] ?? 0;
$professor_id = $_POST['professor_id'] ?? 0;
$response = $_POST['response'] ?? ''; // 'accepted' or 'rejected'

// Έλεγχος εγκυρότητας δεδομένων
if (empty($thesis_id) || empty($professor_id) || !in_array($response, ['accepted', 'rejected']) || $current_professor_id != $professor_id) {
    http_response_code(400);
    exit(json_encode(["success" => false, "message" => "Invalid data or permission denied"]));
}

// Φόρτωση ρυθμίσεων βάσης δεδομένων
require_once "../../config.php";
$conn = getDBConnection();

// Έναρξη transaction για ασφαλή ενημέρωση
$conn->begin_transaction();

try {
    // Ενημέρωση κατάστασης πρόσκλησης στη βάση δεδομένων
    $stmt = $conn->prepare("UPDATE thesis_committee SET invitation_status = ?, response_date = NOW() WHERE thesis_id = ? AND professor_id = ?");
    $stmt->bind_param("sii", $response, $thesis_id, $professor_id);
    $stmt->execute();
    
    // Έλεγχος αν η ενημέρωση ήταν επιτυχής
    if ($stmt->affected_rows == 0) {
        throw new Exception("Could not update invitation.");
    }
    
    // Λογική για αποδοχή πρόσκλησης
    if ($response === 'accepted') {
        // Μετράμε πόσα μέλη έχουν αποδεχθεί την πρόσκληση
        $stmt_count = $conn->prepare("SELECT COUNT(*) as count FROM thesis_committee WHERE thesis_id = ? AND invitation_status = 'accepted' AND role = 'member'");
        $stmt_count->bind_param("i", $thesis_id);
        $stmt_count->execute();
        $count = $stmt_count->get_result()->fetch_assoc()['count'];

        // Αν έχουμε 2 αποδεκτές προσκλήσεις, η επιτροπή είναι πλήρης
        if ($count >= 2) {
            // Ενεργοποίηση διπλωματικής - αλλάζει κατάσταση σε 'active'
            $stmt_activate = $conn->prepare("UPDATE theses SET status = 'active' WHERE id = ?");
            $stmt_activate->bind_param("i", $thesis_id);
            $stmt_activate->execute();
            
            // Δεν χρειάζεται ακύρωση pending προσκλήσεων
            // επειδή ο φοιτητής μπορεί μόνο 2 προσκλήσεις
        }
    }
    
    // Επιβεβαίωση όλων των αλλαγών
    $conn->commit();
    echo json_encode(["success" => true, "message" => "Your response has been recorded."]);

} catch (Exception $e) {
    // Αναίρεση αλλαγών σε περίπτωση σφάλματος
    $conn->rollback();
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "An error occurred: " . $e->getMessage()]);
}

// Κλείσιμο σύνδεσης με τη βάση δεδομένων
$conn->close();
?>