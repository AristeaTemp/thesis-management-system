<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    exit(json_encode(['success' => false, 'message' => 'Unauthorized access.']));
}

$student_id = $_SESSION['user_id'];
$professor_id = $_POST['professor_id'] ?? null;

if (!$professor_id) {
    exit(json_encode(['success' => false, 'message' => 'Δεν επιλέξατε καθηγητή.']));
}

require_once "../../config.php";
$conn = getDBConnection();
if ($conn->connect_error) {
    exit(json_encode(['success' => false, 'message' => 'Database connection error.']));
}
$conn->set_charset("utf8");

$stmt_find_thesis = $conn->prepare("SELECT id FROM theses WHERE student_id = ?");
$stmt_find_thesis->bind_param("i", $student_id);
$stmt_find_thesis->execute();
$result = $stmt_find_thesis->get_result();
if ($result->num_rows === 0) {
    exit(json_encode(['success' => false, 'message' => 'Δεν βρέθηκε η διπλωματική σας.']));
}
$thesis_id = $result->fetch_assoc()['id'];

// Έλεγχος: Μόνο 2 ενεργές προσκλήσεις επιτρέπονται για μέλη επιτροπής
// Μετράμε μόνο τις pending και accepted, όχι τις rejected
$stmt_count = $conn->prepare("SELECT COUNT(*) as count FROM thesis_committee WHERE thesis_id = ? AND role = 'member' AND invitation_status IN ('pending', 'accepted')");
$stmt_count->bind_param("i", $thesis_id);
$stmt_count->execute();
$count_result = $stmt_count->get_result();
$current_invitations = $count_result->fetch_assoc()['count'];

if ($current_invitations >= 2) {
    exit(json_encode(['success' => false, 'message' => 'Μπορείτε να έχετε μόνο 2 ενεργές προσκλήσεις για μέλη της επιτροπής.']));
}

// Η πρόσκληση μπαίνει πάντα ως 'pending'
$role = 'member';
$status = 'pending';
$stmt_insert = $conn->prepare("INSERT INTO thesis_committee (thesis_id, professor_id, role, invitation_status) VALUES (?, ?, ?, ?)");
$stmt_insert->bind_param("iiss", $thesis_id, $professor_id, $role, $status);

if ($stmt_insert->execute()) {
    echo json_encode(['success' => true, 'message' => 'Η πρόσκληση στάλθηκε με επιτυχία.']);
} else {
    // Σφάλμα αν ο καθηγητής έχει ήδη προσκληθεί
    echo json_encode(['success' => false, 'message' => 'Έχετε ήδη προσκαλέσει αυτόν τον καθηγητή.']);
}

$stmt_insert->close();
$conn->close();
?>