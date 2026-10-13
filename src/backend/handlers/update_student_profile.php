<?php
// Handler για ενημέρωση προφίλ φοιτητή
// Επεξεργάζεται την αλλαγή στοιχείων φοιτητή (όνομα, επώνυμο, email)

// Έναρξη session για έλεγχο ταυτοποίησης
session_start();

// Ορισμός content type ως JSON
header('Content-Type: application/json');

// Έλεγχος ότι ο χρήστης είναι συνδεδεμένος και είναι φοιτητής
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    echo json_encode(['message' => 'Δεν επιτρέπεται η πρόσβαση.']);
    exit;
}

$user_id = $_SESSION['user_id'];

require_once "../../config.php";
$conn = getDBConnection();

if ($conn->connect_error) {
    echo json_encode(['message' => 'Σφάλμα σύνδεσης.']);
    exit;
}

// Λήψη δεδομένων από το POST
$street = $_POST['street'] ?? null;
$number = $_POST['number'] ?? null;
$city = $_POST['city'] ?? null;
$postcode = $_POST['postcode'] ?? null;
$landline = $_POST['landline_telephone'] ?? null;
$mobile = $_POST['mobile_telephone'] ?? null;
$email = $_POST['email'] ?? null;

if (empty($mobile) || empty($email)) {
    echo json_encode(['message' => 'Το κινητό τηλέφωνο και το email είναι υποχρεωτικά.']);
    exit;
}

// Χρήση transaction για ακεραιότητα δεδομένων
$conn->begin_transaction();

try {
    // Ενημέρωση του πίνακα students
    $stmt1 = $conn->prepare("UPDATE students SET street = ?, number = ?, city = ?, postcode = ?, landline_telephone = ?, mobile_telephone = ? WHERE user_id = ?");
    $stmt1->bind_param("ssssssi", $street, $number, $city, $postcode, $landline, $mobile, $user_id);
    $stmt1->execute();

    // Ενημέρωση του πίνακα users
    $stmt2 = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
    $stmt2->bind_param("si", $email, $user_id);
    $stmt2->execute();

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Το προφίλ ενημερώθηκε με επιτυχία!']);

} catch (mysqli_sql_exception $exception) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Αποτυχία ενημέρωσης: ' . $exception->getMessage()]);
}

$stmt1->close();
$stmt2->close();
$conn->close();
?>
