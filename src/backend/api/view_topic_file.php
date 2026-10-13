<?php
// API endpoint για προβολή συννημένου αρχείου περιγραφής θέματος διπλωματικής
// Επιτρέπει στον φοιτητή να βλέπει το αρχείο περιγραφής του θέματος

// Έναρξη session για έλεγχο ταυτοποίησης
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Έλεγχος ότι ο χρήστης είναι συνδεδεμένος (φοιτητής ή καθηγητής)
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'student' && $_SESSION['role'] !== 'professor')) {
    http_response_code(401);
    die("Unauthorized access.");
}

// Έλεγχος αν δόθηκε ID θέματος
if (!isset($_GET['topic_id'])) {
    http_response_code(400);
    die("Topic ID is missing.");
}

$topic_id = $_GET['topic_id'];
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

// Φόρτωση ρυθμίσεων βάσης δεδομένων
require_once "../../config.php";
$conn = getDBConnection();

if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed.");
}
$conn->set_charset("utf8");

// Έλεγχος πρόσβασης - φοιτητής ή καθηγητής που συμμετέχει στη διπλωματική
if ($user_role === 'student') {
    $stmt = $conn->prepare("
        SELECT t.final_text_link, t.title
        FROM theses t
        WHERE t.id = ? 
          AND t.student_id = ?
          AND t.status IN ('under_assignment', 'active', 'under_review', 'completed')
    ");
    $stmt->bind_param("ii", $topic_id, $user_id);
} else if ($user_role === 'professor') {
    $stmt = $conn->prepare("
        SELECT t.final_text_link, t.title
        FROM theses t
        JOIN thesis_committee tc ON t.id = tc.thesis_id
        WHERE t.id = ? 
          AND tc.professor_id = ?
          AND t.status IN ('under_assignment', 'active', 'under_review', 'completed')
    ");
    $stmt->bind_param("ii", $topic_id, $user_id);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(403);
    die("Access denied or topic not found.");
}

$thesis = $result->fetch_assoc();
$file_path = $thesis['final_text_link'];


$file_exists = false;
$actual_file_path = '';

if (!empty($file_path)) {
   
    $path_variations = [
        '../handlers/uploads/' . basename($file_path),  
        '../../uploads/' . basename($file_path),  
        '../uploads/' . basename($file_path),
        $file_path,
        '../' . $file_path,
        'uploads/' . basename($file_path),
        '../../' . $file_path
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
    die("Topic description file not found. Tried paths: " . implode(', ', $path_variations ?? []));
}

// Έλεγχος ότι το αρχείο είναι PDF
$file_extension = strtolower(pathinfo($actual_file_path, PATHINFO_EXTENSION));
if ($file_extension !== 'pdf') {
    http_response_code(400);
    die("Invalid file type. Only PDF files are allowed.");
}

// Ορισμός headers για προβολή PDF
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="topic_description_' . $topic_id . '.pdf"');
header('Content-Length: ' . filesize($actual_file_path));

// Εμφάνιση αρχείου
readfile($actual_file_path);

// Κλείσιμο prepared statement και σύνδεσης
$stmt->close();
$conn->close();
?>
