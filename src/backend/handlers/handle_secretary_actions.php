<?php
// handle_secretary_actions.php
session_start();
header('Content-Type: application/json');

// Έλεγχος πρόσβασης
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'secretary') {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit();
}

require_once "../../config.php";
$conn = getDBConnection();

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit();
}
$conn->set_charset("utf8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $thesis_id = $_POST['thesis_id'];
    $action = $_POST['action'];

    switch ($action) {
        case 'mark_as_completed':
            // Έλεγχος προϋποθέσεων για περάτωση
            $stmt = $conn->prepare("
                SELECT 
                    t.*,
                    (SELECT COUNT(*) FROM thesis_committee 
                     WHERE thesis_id = t.id 
                     AND role = 'supervisor') as supervisor_count,
                    (SELECT COUNT(*) FROM thesis_committee 
                     WHERE thesis_id = t.id 
                     AND role = 'member' 
                     AND invitation_status = 'accepted') as members_count,
                    (SELECT COUNT(*) FROM thesis_committee 
                     WHERE thesis_id = t.id 
                     AND (
                        (role = 'supervisor' AND grade IS NOT NULL)
                        OR (role = 'member' AND invitation_status = 'accepted' AND grade IS NOT NULL)
                     )
                    ) as grades_count
                FROM theses t
                WHERE t.id = ? AND t.status = 'under_review'
            ");
            
            $stmt->bind_param("i", $thesis_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $thesis = $result->fetch_assoc();

            // Έλεγχοι εγκυρότητας
            if (!$thesis) {
                echo json_encode(["success" => false, "message" => "Η διπλωματική δεν βρέθηκε ή δεν είναι σε κατάσταση αξιολόγησης"]);
                exit();
            }

            if ($thesis['supervisor_count'] != 1) {
                echo json_encode(["success" => false, "message" => "Πρέπει να υπάρχει ακριβώς ένας επιβλέπων που έχει αποδεχθεί"]);
                exit();
            }

            if ($thesis['members_count'] != 2) {
                echo json_encode(["success" => false, "message" => "Πρέπει να υπάρχουν ακριβώς δύο μέλη που έχουν αποδεχθεί"]);
                exit();
            }

            if ($thesis['grades_count'] != 3) {
                echo json_encode(["success" => false, "message" => "Πρέπει να υπάρχουν βαθμοί από επιβλέποντα και δύο μέλη"]);
                exit();
            }

            if (empty($thesis['nimertis_link'])) {
                echo json_encode(["success" => false, "message" => "Δεν έχει καταχωρηθεί το link του Νημερτής"]);
                exit();
            }

            // Απαιτούμε έτοιμο final_grade (υπολογίζεται όταν υποβληθεί ο 3ος βαθμός)
            if ($thesis['final_grade'] === null) {
                echo json_encode(["success" => false, "message" => "Δεν έχει υπολογιστεί ο τελικός βαθμός."]);
                exit();
            }

            // Ενημέρωση κατάστασης
            $stmt = $conn->prepare("
                UPDATE theses 
                SET status = 'completed',
                    completion_date = CURRENT_DATE
                WHERE id = ?
            ");
            $stmt->bind_param("i", $thesis_id);
            
            if ($stmt->execute()) {
                // Καταγραφή στο ιστορικό
                $stmt = $conn->prepare("
                    INSERT INTO thesis_status_history 
                    (thesis_id, old_status, new_status)
                    VALUES (?, 'under_review', 'completed')
                ");
                $stmt->bind_param("i", $thesis_id);
                $stmt->execute();
                
                echo json_encode(["success" => true, "message" => "Η διπλωματική ολοκληρώθηκε επιτυχώς"]);
            } else {
                echo json_encode(["success" => false, "message" => "Σφάλμα κατά την ενημέρωση: " . $stmt->error]);
            }
            break;

        case 'approve_gs':
            $gs_number = $_POST['gs_number'];
            $stmt = $conn->prepare("UPDATE theses SET gs_number = ? WHERE id = ?");
            $stmt->bind_param("si", $gs_number, $thesis_id);
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Ο ΑΠ/ΓΣ καταχωρήθηκε επιτυχώς."]);
            } else {
                echo json_encode(["success" => false, "message" => "Σφάλμα: " . $stmt->error]);
            }
            break;

        case 'cancel_assignment':
            $cancellation_reason = $_POST['cancellation_reason'];
            $status = 'cancelled';
            $stmt = $conn->prepare("UPDATE theses SET status = ?, cancellation_reason = ? WHERE id = ?");
            $stmt->bind_param("ssi", $status, $cancellation_reason, $thesis_id);
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Η ανάθεση ακυρώθηκε επιτυχώς."]);
            } else {
                echo json_encode(["success" => false, "message" => "Σφάλμα: " . $stmt->error]);
            }
            break;



        default:
            echo json_encode(["success" => false, "message" => "Μη έγκυρη ενέργεια."]);
            break;
    }

    $conn->close();
}
?>