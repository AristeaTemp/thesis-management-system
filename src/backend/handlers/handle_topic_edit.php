<?php
// Αρχείο επεξεργασίας ενημέρωσης υπάρχοντος θέματος διπλωματικής εργασίας
// Επιτρέπει στον καθηγητή να ενημερώνει θέματα που έχει δημιουργήσει

// Έναρξη session για έλεγχο ταυτοποίησης
session_start();

// Έλεγχος ότι ο χρήστης είναι συνδεδεμένος και είναι καθηγητής
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: ../../login.html");
    exit();
}

// Φόρτωση ρυθμίσεων βάσης δεδομένων
require_once "../../config.php";
$conn = getDBConnection();
$conn->set_charset("utf8mb4");

// Έλεγχος σύνδεσης με τη βάση δεδομένων
if ($conn->connect_error) {
    die("Σφάλμα σύνδεσης: " . $conn->connect_error);
}

// Έλεγχος αν η φόρμα υποβλήθηκε με POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Λήψη δεδομένων από τη φόρμα
    $theses_id = $_POST['theses_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $file_path = isset($_POST['existing_pdf_link']) ? $_POST['existing_pdf_link'] : NULL;

    // Επεξεργασία επισύναψης νέου PDF αρχείου
    if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        // Δημιουργία φακέλου uploads αν δεν υπάρχει
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        // Δημιουργία μοναδικού ονόματος αρχείου
        $file_destination = $upload_dir . time() . '_' . basename($_FILES['pdfFile']['name']);
        // Μετακίνηση αρχείου στον φάκελο uploads
        if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $file_destination)) {
            $file_path = $file_destination;
        }
    }

    // Ενημέρωση του θέματος στη βάση δεδομένων
    $stmt = $conn->prepare("UPDATE theses SET title = ?, description = ?, final_text_link = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $description, $file_path, $theses_id);

    if ($stmt->execute()) {
        // Ανακατεύθυνση με μήνυμα επιτυχίας
        $success_message = "Το θέμα '{$title}' ενημερώθηκε επιτυχώς.";
        $stmt->close();
        header("Location: ../../dashboard.php?page=manage_topics&status=success&message=" . urlencode($success_message));
        exit();
    } else {
        // Ανακατεύθυνση με μήνυμα σφάλματος
        $error_message = "Σφάλμα κατά την ενημέρωση του θέματος: " . $stmt->error;
        $stmt->close();
        header("Location: ../../dashboard.php?page=manage_topics&status=error&message=" . urlencode($error_message));
        exit();
    }
}

// Κλείσιμο σύνδεσης με τη βάση δεδομένων
$conn->close();
?>
