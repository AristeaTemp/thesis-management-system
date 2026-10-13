<?php
// Σελίδα επεξεργασίας σύνδεσης χρηστών
// Ελέγχει τα στοιχεία σύνδεσης και δημιουργεί session

// Έναρξη session για διαχείριση χρηστών
session_start();

// Φόρτωση ρυθμίσεων βάσης δεδομένων
require_once 'config.php';

// Δημιουργία σύνδεσης με τη βάση δεδομένων
$conn = getDBConnection();

// Έλεγχος αν η φόρμα υποβλήθηκε με POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Χρήση prepared statements για αποφυγή SQL injection
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $input_username);

    // Λήψη δεδομένων από τη φόρμα
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Εκτέλεση query
    $stmt->execute();
    $result = $stmt->get_result();

    // Έλεγχος αν βρέθηκε χρήστης
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Έλεγχος κωδικού με password_verify() για ασφάλεια
        if (password_verify($input_password, $row['password'])) {
            // Δημιουργία session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            // Ανακατεύθυνση στο dashboard μετά την επιτυχή σύνδεση
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Λάθος κωδικός.";
        }
    } else {
        echo "Δεν βρέθηκε χρήστης με αυτό το όνομα.";
    }

    // Κλείσιμο prepared statement
    $stmt->close();
}

// Κλείσιμο σύνδεσης με τη βάση δεδομένων
$conn->close();
?>