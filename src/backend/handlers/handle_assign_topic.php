<?php
// Έναρξη συνεδρίας για έλεγχο ταυτοποίησης
session_start();

// Έλεγχος αν ο χρήστης είναι συνδεδεμένος και είναι καθηγητής
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.html");
    exit();
}

// Σύνδεση στη βάση δεδομένων και ρύθμιση κωδικοποίησης
require_once "../../config.php";
$conn = getDBConnection();
$conn->set_charset("utf8mb4");

// Έλεγχος σύνδεσης στη βάση
if ($conn->connect_error) {
    die("Σφάλμα σύνδεσης: " . $conn->connect_error);
}

// Επεξεργασία αιτήματος ανάθεσης θέματος
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Λήψη παραμέτρων από τη φόρμα
    $student_identifier = trim($_POST['student_identifier']); // Αριθμός μητρώου ή ονοματεπώνυμο φοιτητή
    $topic_id = $_POST['topic_id']; // ID του θέματος προς ανάθεση
    $professor_id = $_SESSION['user_id']; // ID του καθηγητή που κάνει την ανάθεση

        // Έναρξη transaction για ατομικότητα των ενεργειών
    $conn->begin_transaction();
    try {
        // Βήμα 1: Αναζήτηση φοιτητή με βάση τον αριθμό μητρώου ή το ονοματεπώνυμο
        $stmt_student = $conn->prepare("SELECT user_id FROM students WHERE student_number = ? OR CONCAT(name, ' ', surname) = ?");
        $stmt_student->bind_param("ss", $student_identifier, $student_identifier);
        $stmt_student->execute();
        $student_result = $stmt_student->get_result();
        
        // Έλεγχος αν βρέθηκε ο φοιτητής
        if ($student_result->num_rows === 0) {
            throw new Exception("Δεν βρέθηκε φοιτητής με στοιχεία: " . htmlspecialchars($student_identifier));
        }
        $student = $student_result->fetch_assoc();
        $student_id = $student['user_id'];
        $stmt_student->close();

        // Βήμα 2: Ενημέρωση της διπλωματικής με τα στοιχεία του φοιτητή
        // Θέτουμε την κατάσταση σε 'under_assignment' και καταγράφουμε την ημερομηνία ανάθεσης
        $stmt_update_thesis = $conn->prepare("UPDATE theses SET student_id = ?, assignment_date = NOW(), status = 'under_assignment' WHERE id = ? AND supervisor_id = ?");
        $stmt_update_thesis->bind_param("iii", $student_id, $topic_id, $professor_id);
        $stmt_update_thesis->execute();
        
        if ($stmt_update_thesis->affected_rows === 0) {
            throw new Exception("Could not assign thesis. It might be already assigned or you are not the supervisor.");
        }
        $stmt_update_thesis->close();

        $conn->commit();
        
        $success_message = "Η ανάθεση του θέματος στον φοιτητή έγινε με επιτυχία.";
        header("Location: ../../dashboard.php?page=assign_topic&status=success&message=" . urlencode($success_message));
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        header("Location: ../../dashboard.php?page=assign_topic&status=error&message=" . urlencode($e->getMessage()));
        exit();
    }
}

$conn->close();
?>