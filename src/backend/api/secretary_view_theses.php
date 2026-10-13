<?php
// api/secretary_view_theses.php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'secretary') {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized access."]);
    exit();
}

// Database connection details
require_once "../../config.php";
$conn = getDBConnection();

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit();
}
$conn->set_charset("utf8");

$sql = "
    SELECT
        t.id as thesis_id,
        t.title,
        t.status,
        s.name as student_name,
        s.surname as student_surname,
        GROUP_CONCAT(CONCAT(p.name, ' ', p.surname, ' (', tc.role, ')') SEPARATOR ', ') as committee_members
    FROM theses t
    LEFT JOIN students s ON t.student_id = s.user_id
    LEFT JOIN thesis_committee tc ON t.id = tc.thesis_id
    LEFT JOIN professors p ON tc.professor_id = p.user_id
    WHERE t.status IN ('active', 'under_review')
      AND (tc.role = 'supervisor' OR tc.invitation_status = 'accepted')
    GROUP BY t.id
    ORDER BY t.id DESC
";

$result = $conn->query($sql);

$theses = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['student_name'] = $row['student_name'] ? $row['student_name'] . ' ' . $row['student_surname'] : '—';
        unset($row['student_surname']);
        $theses[] = $row;
    }
}

$conn->close();

echo json_encode($theses);
?>