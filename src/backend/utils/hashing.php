<?php
// Συνάρτηση για την κρυπτογράφηση κωδικών χρηστών
// Μετατρέπει όλους τους απλούς κωδικούς σε hashed passwords

// ΠΡΟΣΟΧΗ: εργαλείο μίας χρήσης για την αρχική δημιουργία των hashes.
// ΜΗΝ το τρέξετε στη βάση του demo: τα passwords είναι ήδη hashed και θα χαλάσουν τα logins.

// Στοιχεία σύνδεσης βάσης δεδομένων (από το config.php)
require_once "../../config.php";

// Σύνδεση με τη βάση δεδομένων
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Έλεγχος σύνδεσης
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Επιλογή όλων των χρηστών με απλούς κωδικούς
$sql = "SELECT id, password FROM users";
$result = $conn->query($sql);

// Έλεγχος αν βρέθηκαν χρήστες
if ($result->num_rows > 0) {
    // Επεξεργασία κάθε χρήστη
    while($row = $result->fetch_assoc()) {
        // Κρυπτογράφηση του απλού κωδικού
        $hashed_password = password_hash($row['password'], PASSWORD_DEFAULT);
        
        // Ενημέρωση του κωδικού στη βάση δεδομένων με την κρυπτογραφημένη έκδοση
        $update_sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $hashed_password, $row['id']);
        $stmt->execute();
        $stmt->close();
    }
    echo "Όλοι οι κωδικοί χρηστών έχουν κρυπτογραφηθεί και ενημερωθεί επιτυχώς.";
} else {
    echo "Δεν βρέθηκαν χρήστες προς ενημέρωση.";
}

// Κλείσιμο σύνδεσης με τη βάση δεδομένων
$conn->close();
?>