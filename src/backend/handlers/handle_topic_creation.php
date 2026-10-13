<?php
// Αρχείο επεξεργασίας δημιουργίας νέου θέματος διπλωματικής εργασίας
// Επιτρέπει στον καθηγητή να δημιουργεί νέα θέματα με τίτλο, περιγραφή και PDF

// Έναρξη session για έλεγχο ταυτοποίησης
session_start();

// Έλεγχος ότι ο χρήστης είναι συνδεδεμένος και είναι καθηγητής
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.html");
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
    $professor_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $file_path = NULL;

    // Επεξεργασία επισύναψης PDF αρχείου
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

    // Έναρξη transaction για ασφαλή αποθήκευση
    $conn->begin_transaction();

    try {
        // Βήμα 1: Εισαγωγή νέου θέματος στον πίνακα 'theses'
        $stmt_thesis = $conn->prepare("INSERT INTO theses (title, description, supervisor_id, final_text_link) VALUES (?, ?, ?, ?)");
        $stmt_thesis->bind_param("ssis", $title, $description, $professor_id, $file_path);
        $stmt_thesis->execute();

        $last_thesis_id = $conn->insert_id;
        $stmt_thesis->close();

        // Βήμα 2: Εισαγωγή του καθηγητή ως επιβλέποντα στην επιτροπή
        $role = 'supervisor';
        $status = 'accepted';
        $stmt_committee = $conn->prepare("INSERT INTO thesis_committee (thesis_id, professor_id, role, invitation_status, response_date) VALUES (?, ?, ?, ?, NOW())");
        $stmt_committee->bind_param("iiss", $last_thesis_id, $professor_id, $role, $status);
        $stmt_committee->execute();
        $stmt_committee->close();

        // Επιβεβαίωση transaction
        $conn->commit();

        // Ανακατεύθυνση με μήνυμα επιτυχίας
        $success_message = "Το θέμα '{$title}' δημιουργήθηκε επιτυχώς.";
        header("Location: ../../dashboard.php?page=manage_topics&status=success&message=" . urlencode($success_message));
        exit();

    } catch (Exception $e) {
        // Αναίρεση transaction σε περίπτωση σφάλματος
        $conn->rollback();
        $error_message = "Παρουσιάστηκε σφάλμα: " . $e->getMessage();
        header("Location: ../../dashboard.php?page=manage_topics&status=error&message=" . urlencode($error_message));
        exit();
    }
}

// Κλείσιμο σύνδεσης με τη βάση δεδομένων
$conn->close();
?>