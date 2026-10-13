<?php
// Αρχείο εξαγωγής διπλωματικών εργασιών σε CSV ή JSON μορφή
// Επιτρέπει στον καθηγητή να εξάγει τη λίστα των διπλωματικών του

// Έναρξη session για έλεγχο ταυτοποίησης
session_start();

// Έλεγχος ότι ο χρήστης είναι συνδεδεμένος και είναι καθηγητής
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    http_response_code(401);
    die("Unauthorized access.");
}

// Λήψη ID καθηγητή και μορφής εξαγωγής
$professor_id = $_SESSION['user_id'];
$format = $_GET['format'] ?? 'json'; // Προεπιλογή σε json αν δεν οριστεί

// Φόρτωση ρυθμίσεων βάσης δεδομένων
require_once "../../config.php";
$conn = getDBConnection();

if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed.");
}

// Query για διπλωματικές που συμμετέχει ο καθηγητής
$sql = "
    SELECT
        t.id as thesis_id,
        t.title,
        CONCAT(s.name, ' ', s.surname) as student_name,
        tc.role,
        t.status
    FROM thesis_committee tc
    JOIN theses t ON tc.thesis_id = t.id
    LEFT JOIN students s ON t.student_id = s.user_id
    WHERE tc.professor_id = ?
      AND tc.invitation_status IN ('accepted', 'cancelled')
";

// Παραμέτροι για prepared statement
$params = [$professor_id];
$types = "i";

// Προσθήκη φίλτρων αν δόθηκαν
if (!empty($_GET['status'])) {
    $sql .= " AND t.status = ?";
    $params[] = $_GET['status'];
    $types .= "s";
}
if (!empty($_GET['role'])) {
    $sql .= " AND tc.role = ?";
    $params[] = $_GET['role'];
    $types .= "s";
}

// Εκτέλεση query και λήψη δεδομένων
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();

// Δημιουργία ονόματος αρχείου με ημερομηνία
$filename = "theses_export_" . date('Y-m-d') . "." . $format;

// Εξαγωγή σε JSON μορφή
if ($format === 'json') {
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} 
// Εξαγωγή σε CSV μορφή
elseif ($format === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    // Έλεγχος αν υπάρχουν δεδομένα
    if (empty($data)) {
        exit();
    }
    
    $output = fopen('php://output', 'w');
    
    // Προσθήκη BOM για υποστήριξη ελληνικών χαρακτήρων στο Excel
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

    // Γράφουμε τα headers του CSV
    fputcsv($output, array_keys($data[0]));
    
    // Γράφουμε τα δεδομένα
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
}
?>