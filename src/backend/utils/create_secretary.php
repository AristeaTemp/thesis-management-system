<?php
// Σύνδεση στη βάση δεδομένων (στοιχεία από το config.php)
require_once "../../config.php";
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Σφάλμα σύνδεσης στη βάση δεδομένων: " . $conn->connect_error);
}

// Δεδομένα για τη Γραμματεία
$username = "secretary";
$email = "secretary@upatras.gr";
$name = "Νίκη";
$surname = "Γραμματικού";
$role = "secretary";
$password_plain = "upatras123";

// Hashing του κωδικού
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

// Έναρξη συναλλαγής (transaction) για να διασφαλιστεί η ακεραιότητα των δεδομένων
$conn->begin_transaction();

try {
    // Εισαγωγή στον πίνακα users
    $stmt_users = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
    $stmt_users->bind_param("ssss", $username, $password_hashed, $email, $role);
    $stmt_users->execute();
    
    // Ανάκτηση του user_id που μόλις δημιουργήθηκε
    $user_id = $stmt_users->insert_id;
    $stmt_users->close();

    // Εισαγωγή στον πίνακα secretaries
    $stmt_secretaries = $conn->prepare("INSERT INTO secretaries (user_id, name, surname) VALUES (?, ?, ?)");
    $stmt_secretaries->bind_param("iss", $user_id, $name, $surname);
    $stmt_secretaries->execute();
    $stmt_secretaries->close();

    // Ολοκλήρωση της συναλλαγής
    $conn->commit();
    echo "Η εγγραφή για τη Γραμματεία δημιουργήθηκε επιτυχώς.";

} catch (Exception $e) {
    // Σε περίπτωση σφάλματος, επιστροφή στην αρχική κατάσταση
    $conn->rollback();
    echo "Σφάλμα κατά τη δημιουργία της εγγραφής: " . $e->getMessage();
}

$conn->close();
?>