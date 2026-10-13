<?php
// Handler για την ενημέρωση των στοιχείων παρουσίασης διπλωματικής
session_start();
header('Content-Type: application/json; charset=utf-8');

// Έλεγχος ταυτοποίησης - μόνο φοιτητές μπορούν να ενημερώσουν τα στοιχεία παρουσίασης
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    http_response_code(401);
    exit(json_encode(['success' => false, 'message' => 'Μη εξουσιοδοτημένη πρόσβαση.']));
}

// Λήψη JSON δεδομένων
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Έλεγχος απαραίτητων πεδίων
if (!isset($data['presentation_date']) || !isset($data['presentation_time']) || 
    !isset($data['presentation_type']) || !isset($data['presentation_location'])) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Ελλιπή στοιχεία παρουσίασης.']));
}

// Σύνδεση στη βάση δεδομένων
require_once "../../config.php";
$conn = getDBConnection();
$conn->set_charset("utf8");

try {
    // Εύρεση της διπλωματικής του φοιτητή
    $stmt = $conn->prepare("SELECT id FROM theses WHERE student_id = ? AND status = 'under_review'");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Δεν βρέθηκε διπλωματική σε κατάσταση 'Υπό Εξέταση'.");
    }
    
    $thesis = $result->fetch_assoc();
    $thesis_id = $thesis['id'];
    
    // Ενημέρωση των στοιχείων παρουσίασης
    $stmt = $conn->prepare("
        UPDATE theses 
        SET presentation_date = ?, 
            presentation_time = ?, 
            presentation_type = ?, 
            presentation_location = ?,
            presentation_details_submitted = TRUE
        WHERE id = ?
    ");
    
    $stmt->bind_param("ssssi", 
        $data['presentation_date'],
        $data['presentation_time'],
        $data['presentation_type'],
        $data['presentation_location'],
        $thesis_id
    );
    
    if (!$stmt->execute()) {
        throw new Exception("Σφάλμα κατά την αποθήκευση των στοιχείων.");
    }
    
    echo json_encode(['success' => true, 'message' => 'Τα στοιχεία παρουσίασης αποθηκεύτηκαν επιτυχώς.']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>