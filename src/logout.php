<?php
// Σελίδα αποσύνδεσης χρηστών
// Καθαρίζει το session και ανακατευθύνει στη σελίδα σύνδεσης

// Έναρξη session για πρόσβαση στα session data
session_start();

// Καθαρισμός όλων των session variables
session_unset();

// Καταστροφή του session
session_destroy();

// Ανακατεύθυνση στη σελίδα σύνδεσης
header("Location: login.html");
exit();
?>