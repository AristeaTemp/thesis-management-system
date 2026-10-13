<?php
// Έναρξη συνεδρίας και ρύθμιση κεφαλίδων για JSON απόκριση
session_start();
header('Content-Type: application/json; charset=utf-8');

// Έλεγχος εξουσιοδότησης - μόνο καθηγητές έχουν πρόσβαση
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    http_response_code(401);
    echo json_encode(["error" => "Μη εξουσιοδοτημένη πρόσβαση."]);
    exit();
}

// Λήψη ID καθηγητή και σύνδεση στη βάση δεδομένων
$professor_id = $_SESSION['user_id'];
require_once "../../config.php";
$conn = getDBConnection();
$conn->set_charset("utf8mb4");

// Έλεγχος σύνδεσης με τη βάση δεδομένων
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Σφάλμα σύνδεσης στη βάση δεδομένων."]);
    exit();
}

// Ανάκτηση διπλωματικών με αποδεκτές προσκλήσεις
$sql = "
    SELECT
        t.id as thesis_id,
        t.title,
        t.status,
        tc.role,
        CONCAT(s.name, ' ', s.surname) as student_name
    FROM thesis_committee tc
    JOIN theses t ON tc.thesis_id = t.id
    LEFT JOIN students s ON t.student_id = s.user_id
    WHERE tc.professor_id = ?
      AND tc.invitation_status IN ('accepted', 'cancelled')
";

$params = [$professor_id];
$types = "i";

// Φιλτράρισμα με βάση την κατάσταση της διπλωματικής
if (!empty($_GET['status'])) {
    $sql .= " AND t.status = ?";
    $params[] = $_GET['status'];
    $types .= "s";
}

// Φιλτράρισμα με βάση το ρόλο του καθηγητή στην επιτροπή
if (!empty($_GET['role'])) {
    $sql .= " AND tc.role = ?";
    $params[] = $_GET['role'];
    $types .= "s";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$theses = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

// The only output of this file should be this line
echo json_encode($theses);
?>