<?php
// Δημόσιο API για ανακοινώσεις παρουσίασης διπλωματικών
// Εμφανίζει διπλωματικές με κατάσταση 'under_review'

// Ρύθμιση headers για JSON/XML και CORS
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Cache-busting headers
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Σύνδεση στη βάση δεδομένων
require_once 'config.php';

try {
    $conn = getDBConnection();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Σφάλμα σύνδεσης στη βάση δεδομένων']);
    exit();
}

// Λήψη παραμέτρων από το URL
$format = isset($_GET['format']) ? strtolower($_GET['format']) : 'json'; // Μορφή: json ή xml
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;   // Ημερομηνία έναρξης
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;         // Ημερομηνία λήξης

// Έλεγχος μορφής ημερομηνιών (YYYY-MM-DD)
if ($start_date && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $start_date)) {
    http_response_code(400);
    echo json_encode(['error' => 'Λάθος μορφή start_date. Χρησιμοποιήστε YYYY-MM-DD']);
    exit;
}

if ($end_date && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $end_date)) {
    http_response_code(400);
    echo json_encode(['error' => 'Λάθος μορφή end_date. Χρησιμοποιήστε YYYY-MM-DD']);
    exit;
}

// SQL query για λήψη διπλωματικών με κατάσταση 'under_review'
$sql = "SELECT
            t.id,
            t.title,
            t.presentation_date,
            t.presentation_time,
            t.presentation_location,
            s.name as student_name,
            s.surname as student_surname,
            s.student_number,
            p.name as supervisor_name,
            p.surname as supervisor_surname
        FROM theses t
        INNER JOIN students s ON t.student_id = s.user_id
        INNER JOIN thesis_committee tc ON t.id = tc.thesis_id AND tc.role = 'supervisor'
        INNER JOIN professors p ON tc.professor_id = p.user_id
        WHERE t.status = 'under_review'
        AND t.presentation_date IS NOT NULL
        AND t.presentation_time IS NOT NULL
        AND s.user_id IS NOT NULL
        AND p.user_id IS NOT NULL";

// Προσθήκη φίλτρου ημερομηνιών αν δοθούν
if ($start_date) {
    $sql .= " AND t.presentation_date >= ?";
}
if ($end_date) {
    $sql .= " AND t.presentation_date <= ?";
}

$sql .= " ORDER BY t.presentation_date ASC, t.presentation_time ASC";

try {
    // Εκτέλεση query
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Σφάλμα προετοιμασίας query: " . $conn->error);
    }
    
    // Σύνδεση παραμέτρων ημερομηνιών
    if ($start_date && $end_date) {
        $stmt->bind_param("ss", $start_date, $end_date);
    } elseif ($start_date) {
        $stmt->bind_param("s", $start_date);
    } elseif ($end_date) {
        $stmt->bind_param("s", $end_date);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    if (!$result) {
        throw new Exception("Σφάλμα εκτέλεσης query: " . $stmt->error);
    }
    
    // Λήψη αποτελεσμάτων
    $announcements = [];
    while ($row = $result->fetch_assoc()) {
        $announcements[] = $row;
    }
    
    // Μορφοποίηση δεδομένων
    $formatted_announcements = [];
    foreach ($announcements as $announcement) {
        $formatted_announcements[] = [
            'id' => $announcement['id'],
            'title' => $announcement['title'],
            'presentation_date' => $announcement['presentation_date'],
            'presentation_time' => $announcement['presentation_time'],
            'presentation_location' => $announcement['presentation_location'],
            'student' => [
                'name' => $announcement['student_name'],
                'surname' => $announcement['student_surname'],
                'student_number' => $announcement['student_number']
            ],
            'supervisor' => [
                'name' => $announcement['supervisor_name'],
                'surname' => $announcement['supervisor_surname']
            ]
        ];
    }
    
    // Εξαγωγή σε XML ή JSON
    if ($format === 'xml') {
        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<announcements>' . "\n";
        
        foreach ($formatted_announcements as $announcement) {
            echo '  <announcement>' . "\n";
            echo '    <id>' . htmlspecialchars($announcement['id']) . '</id>' . "\n";
            echo '    <title>' . htmlspecialchars($announcement['title']) . '</title>' . "\n";
            echo '    <presentation_date>' . htmlspecialchars($announcement['presentation_date']) . '</presentation_date>' . "\n";
            echo '    <presentation_time>' . htmlspecialchars($announcement['presentation_time']) . '</presentation_time>' . "\n";
            echo '    <presentation_location>' . htmlspecialchars($announcement['presentation_location']) . '</presentation_location>' . "\n";
            echo '    <student>' . "\n";
            echo '      <name>' . htmlspecialchars($announcement['student']['name']) . '</name>' . "\n";
            echo '      <surname>' . htmlspecialchars($announcement['student']['surname']) . '</surname>' . "\n";
            echo '      <student_number>' . htmlspecialchars($announcement['student']['student_number']) . '</student_number>' . "\n";
            echo '    </student>' . "\n";
            echo '    <supervisor>' . "\n";
            echo '      <name>' . htmlspecialchars($announcement['supervisor']['name']) . '</name>' . "\n";
            echo '      <surname>' . htmlspecialchars($announcement['supervisor']['surname']) . '</surname>' . "\n";
            echo '    </supervisor>' . "\n";
            echo '  </announcement>' . "\n";
        }
        
        echo '</announcements>';
    } else {
        // Προεπιλογή JSON
        echo json_encode([
            'total' => count($formatted_announcements),
            'announcements' => $formatted_announcements
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Σφάλμα query: ' . $e->getMessage()]);
} finally {
    $conn->close();
}
?>