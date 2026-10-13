<?php
// API endpoint για ασφαλή προβολή πρόχειρου κειμένου διπλωματικής εργασίας
// Επιτρέπει στον καθηγητή να βλέπει το πρόχειρο κείμενο όταν η διπλωματική είναι "υπό εξέταση"

// Έναρξη session για έλεγχο ταυτοποίησης
session_start();

// Έλεγχος ότι ο χρήστης είναι συνδεδεμένος και είναι καθηγητής
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    http_response_code(401);
    die("Unauthorized access.");
}

// Έλεγχος αν δόθηκε ID διπλωματικής
if (!isset($_GET['thesis_id'])) {
    http_response_code(400);
    die("Thesis ID is missing.");
}

$thesis_id = $_GET['thesis_id'];
$professor_id = $_SESSION['user_id'];

// Φόρτωση ρυθμίσεων βάσης δεδομένων
require_once "../../config.php";
$conn = getDBConnection();

// Έλεγχος σύνδεσης με τη βάση δεδομένων
if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed.");
}
$conn->set_charset("utf8");

// Έλεγχος ότι ο καθηγητής συμμετέχει στη διπλωματική και είναι "υπό εξέταση"
$stmt = $conn->prepare("
    SELECT t.draft_file_path, t.status
    FROM theses t
    JOIN thesis_committee tc ON t.id = tc.thesis_id
    WHERE t.id = ? 
      AND tc.professor_id = ? 
      AND t.status = 'under_review'
      AND tc.invitation_status IN ('accepted', 'cancelled')
");
$stmt->bind_param("ii", $thesis_id, $professor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(403);
    die("Access denied or thesis not found.");
}

$thesis = $result->fetch_assoc();
$draft_file_path = $thesis['draft_file_path'];

// Check if file exists with different path variations
$file_exists = false;
$actual_file_path = '';

if (!empty($draft_file_path)) {
    // Try different path variations
    $path_variations = [
        '../handlers/uploads/' . basename($draft_file_path),  // Correct path from api to handlers/uploads
        '../../uploads/' . basename($draft_file_path),
        '../uploads/' . basename($draft_file_path),
        $draft_file_path,
        '../' . $draft_file_path,
        'uploads/' . basename($draft_file_path),
        '../../' . $draft_file_path
    ];

    foreach ($path_variations as $path) {
        if (file_exists($path)) {
            $file_exists = true;
            $actual_file_path = $path;
            break;
        }
    }
}

if (!$file_exists) {
    http_response_code(404);
    die("Draft file not found. Tried paths: " . implode(', ', $path_variations ?? []));
}

// Έλεγχος ότι το αρχείο είναι PDF
$file_extension = strtolower(pathinfo($actual_file_path, PATHINFO_EXTENSION));
if ($file_extension !== 'pdf') {
    http_response_code(400);
    die("Invalid file type. Only PDF files are allowed.");
}

// Ορισμός headers για προβολή PDF
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="draft_thesis_' . $thesis_id . '.pdf"');
header('Content-Length: ' . filesize($actual_file_path));

// Εμφάνιση αρχείου
readfile($actual_file_path);

// Κλείσιμο prepared statement και σύνδεσης
$stmt->close();
$conn->close();
?>
