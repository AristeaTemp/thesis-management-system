<?php
// Handler για υποβολή υλικών διπλωματικής εργασίας από φοιτητή
// Επεξεργάζεται την επισύναψη αρχείων και ενημερώνει τη βάση δεδομένων

// Απενεργοποίηση warnings που θα χαλούσαν το JSON output
error_reporting(0);
ini_set('display_errors', 0);

// Έναρξη session για έλεγχο ταυτοποίησης
session_start();

// Ορισμός content type ως JSON
header('Content-Type: application/json');

try {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
        echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
        exit();
    }

    // Database Connection (credentials come from config.php)
    require_once "../../config.php";
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
        exit();
    }

    $student_id = $_SESSION['user_id'];
    $thesis_id = $_POST['thesis_id'] ?? '';
    $presentation_date = $_POST['presentation_date'] ?? '';
    $presentation_time = $_POST['presentation_time'] ?? '';
    $presentation_location = $_POST['presentation_location'] ?? '';
    $material_links = $_POST['material_links'] ?? '';
    $nimertis_link = $_POST['nimertis_link'] ?? '';
    $draft_file_path = $_POST['existing_draft_path'] ?? '';

    if (isset($_FILES['draft_file']) && $_FILES['draft_file']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        // Δημιουργία φακέλου uploads αν δεν υπάρχει
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        // Δημιουργία μοναδικού ονόματος αρχείου
        $file_destination = $upload_dir . time() . '_' . basename($_FILES['draft_file']['name']);

        if (move_uploaded_file($_FILES['draft_file']['tmp_name'], $file_destination)) {
            $draft_file_path = $file_destination;
        }
    }

    $stmt = $conn->prepare("UPDATE theses SET 
        presentation_date = ?, 
        presentation_time = ?, 
        presentation_location = ?, 
        material_links = ?, 
        nimertis_link = ?,
        draft_file_path = ?
        WHERE id = ? AND student_id = ?");

    $stmt->bind_param("ssssssii", 
        $presentation_date, 
        $presentation_time, 
        $presentation_location, 
        $material_links, 
        $nimertis_link,
        $draft_file_path,
        $thesis_id,
        $student_id
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Οι πληροφορίες αποθηκεύτηκαν!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Σφάλμα: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Σφάλμα: ' . $e->getMessage()]);
}
?>