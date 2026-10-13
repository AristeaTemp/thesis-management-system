<?php
// Ρυθμίσεις βάσης δεδομένων
$servername = "localhost";        // Διεύθυνση server
$username_db = "root";            // Όνομα χρήστη
$password_db = "";                // Κωδικός πρόσβασης
$dbname = "thesis_system";        // Όνομα βάσης δεδομένων

// Συνάρτηση για σύνδεση στη βάση δεδομένων
function getDBConnection() {
    global $servername, $username_db, $password_db, $dbname;
    
    // Δημιουργία σύνδεσης
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);
    
    // Έλεγχος σύνδεσης
    if ($conn->connect_error) {
        die("Σφάλμα σύνδεσης: " . $conn->connect_error);
    }
    
    // Ρύθμιση charset για ελληνικά
    $conn->set_charset("utf8");
    return $conn;
}

// Ρυθμίσεις error reporting
error_reporting(0);           // Απενεργοποίηση εμφάνισης errors
ini_set('display_errors', 0); // Απενεργοποίηση εμφάνισης errors
?>