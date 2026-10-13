<?php
// Έναρξη συνεδρίας και ρύθμιση κεφαλίδων για JSON απόκριση
session_start();
header('Content-Type: application/json; charset=utf-8');

// ΕΛΕΓΧΟΣ 1: Επιβεβαίωση ότι ο χρήστης είναι συνδεδεμένος καθηγητής
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    http_response_code(401);
    exit(json_encode(["success" => false, "message" => "Μη εξουσιοδοτημένη πρόσβαση."]));
}

// ΕΛΕΓΧΟΣ 2: Επιβεβαίωση ότι είναι αίτημα POST με ενέργεια
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['action'])) {
    http_response_code(400);
    exit(json_encode(["success" => false, "message" => "Μη έγκυρη μέθοδος αιτήματος ή απουσία ενέργειας."]));
}

// Σύνδεση στη βάση δεδομένων 
require_once "../../config.php"; // credentials come from config.php
$conn = new mysqli($servername, $username_db, $password_db, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    exit(json_encode(["success" => false, "message" => "Αποτυχία σύνδεσης στη βάση δεδομένων."]));
}
$conn->set_charset("utf8");

// Λήψη δεδομένων από το POST και τη συνεδρία
$action = $_POST['action']; // Η ενέργεια που ζητήθηκε
$thesis_id = $_POST['thesis_id'] ?? 0; // ID της διπλωματικής
$professor_id = $_SESSION['user_id']; // ID του καθηγητή

// Έλεγχος ρόλου χρήστη για τη συγκεκριμένη διπλωματική (Επιβλέπων ή  Μέλος) 
$is_supervisor = false;
$is_member = false;
if ($thesis_id > 0) {
    // Ανάκτηση ρόλου από τη βάση δεδομένων
    $stmt_check_role = $conn->prepare("SELECT role FROM thesis_committee WHERE thesis_id = ? AND professor_id = ?");
    $stmt_check_role->bind_param("ii", $thesis_id, $professor_id);
    $stmt_check_role->execute();
    $role_result = $stmt_check_role->get_result();
    if ($role_row = $role_result->fetch_assoc()) {
        $is_member = true; // Είναι μέλος της επιτροπής
        if ($role_row['role'] === 'supervisor') {
            $is_supervisor = true; // Είναι ο επιβλέπων καθηγητής
        }
    }
    $stmt_check_role->close();
}

switch ($action) {

    case 'submit_grade':
        if (!$is_member) { exit(json_encode(["success" => false, "message" => "Permission denied. You are not a member of this committee."])); }
        
        $grade = $_POST['grade'] ?? null;
        if ($grade === null || !is_numeric($grade) || $grade < 0 || $grade > 10) {
             exit(json_encode(["success" => false, "message" => "Invalid grade provided."]));
        }

        $conn->begin_transaction();
        try {
            $stmt_update_member_grade = $conn->prepare("UPDATE thesis_committee SET grade = ? WHERE thesis_id = ? AND professor_id = ?");
            $stmt_update_member_grade->bind_param("dii", $grade, $thesis_id, $professor_id);
            $stmt_update_member_grade->execute();
            
            // Υπολογίζουμε μόνο όταν υπάρχουν ακριβώς 3 βαθμοί:
            // Επιβλέπων καθηγητής
            // Δύο μέλη με invitation_status='accepted'
            $stmt_count_applicable = $conn->prepare("
                SELECT 
                    SUM(CASE WHEN role = 'supervisor' THEN 1 ELSE 0 END) AS supervisors,
                    SUM(CASE WHEN role = 'member' AND invitation_status = 'accepted' THEN 1 ELSE 0 END) AS accepted_members,
                    SUM(CASE WHEN (role = 'supervisor' AND grade IS NOT NULL) OR (role = 'member' AND invitation_status = 'accepted' AND grade IS NOT NULL) THEN 1 ELSE 0 END) AS graded_count
                FROM thesis_committee
                WHERE thesis_id = ?
            ");
            $stmt_count_applicable->bind_param("i", $thesis_id);
            $stmt_count_applicable->execute();
            $counts = $stmt_count_applicable->get_result()->fetch_assoc();

            if ((int)$counts['supervisors'] === 1 && (int)$counts['accepted_members'] === 2 && (int)$counts['graded_count'] === 3) {
                $stmt_avg = $conn->prepare("
                    SELECT AVG(grade) as final_grade 
                    FROM thesis_committee 
                    WHERE thesis_id = ? AND (
                        (role = 'supervisor') OR (role = 'member' AND invitation_status = 'accepted')
                    )
                ");
                $stmt_avg->bind_param("i", $thesis_id);
                $stmt_avg->execute();
                $final_grade = $stmt_avg->get_result()->fetch_assoc()['final_grade'];
                $stmt_update_final = $conn->prepare("UPDATE theses SET final_grade = ? WHERE id = ?");
                $stmt_update_final->bind_param("di", $final_grade, $thesis_id);
                $stmt_update_final->execute();
            }
            
            $conn->commit();
            echo json_encode(["success" => true, "message" => "Ο βαθμός σας καταχωρήθηκε επιτυχώς!"]);
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(["success" => false, "message" => "Σφάλμα κατά την καταχώρηση του βαθμού."]);
        }
        break;

    case 'add_note':
        if (!$is_member) { exit(json_encode(["success" => false, "message" => "Permission denied."])); }
        $note_text = trim($_POST['note_text'] ?? '');
        if (empty($note_text)) { exit(json_encode(["success" => false, "message" => "Η σημείωση δεν μπορεί να είναι κενή."])); }
        
        $stmt = $conn->prepare("INSERT INTO thesis_notes (thesis_id, professor_id, note_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $thesis_id, $professor_id, $note_text);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Η σημείωση αποθηκεύτηκε."]);
        } else {
            echo json_encode(["success" => false, "message" => "Η αποθήκευση απέτυχε."]);
        }
        break;
        
    case 'change_status_to_review':
        if (!$is_supervisor) { exit(json_encode(["success" => false, "message" => "Permission denied."])); }
        
        $stmt_check = $conn->prepare("SELECT COUNT(*) as accepted_count FROM thesis_committee WHERE thesis_id = ? AND invitation_status = 'accepted'");
        $stmt_check->bind_param("i", $thesis_id);
        $stmt_check->execute();
        $count = $stmt_check->get_result()->fetch_assoc()['accepted_count'];
        if ($count < 3) { exit(json_encode(["success" => false, "message" => "Η επιτροπή πρέπει να είναι πλήρης (3 μέλη) πριν την αλλαγή κατάστασης."])); }
        
        $stmt = $conn->prepare("UPDATE theses SET status = 'under_review' WHERE id = ?");
        $stmt->bind_param("i", $thesis_id);
        if ($stmt->execute()) {
            $stmt_log = $conn->prepare("INSERT INTO thesis_status_history (thesis_id, old_status, new_status) VALUES (?, 'active', 'under_review')");
            $stmt_log->bind_param("i", $thesis_id);
            $stmt_log->execute();
            echo json_encode(["success" => true, "message" => "Η κατάσταση άλλαξε σε 'Υπό Εξέταση'."]);
        } else { echo json_encode(["success" => false, "message" => "Η ενέργεια απέτυχε."]); }
        break;

    case 'cancel_pre_assignment':
         if (!$is_supervisor) { exit(json_encode(["success" => false, "message" => "Permission denied."])); }
         $conn->begin_transaction();
         try {
             $stmt_thesis = $conn->prepare("UPDATE theses SET student_id = NULL, assignment_date = NULL, status = 'under_assignment' WHERE id = ? AND status = 'under_assignment'");
             $stmt_thesis->bind_param("i", $thesis_id);
             $stmt_thesis->execute();
             $stmt_committee = $conn->prepare("DELETE FROM thesis_committee WHERE thesis_id = ?");
             $stmt_committee->bind_param("i", $thesis_id);
             $stmt_committee->execute();
             $stmt_log = $conn->prepare("INSERT INTO thesis_status_history (thesis_id, old_status, new_status) VALUES (?, 'under_assignment', 'under_assignment')");
             $stmt_log->bind_param("i", $thesis_id);
             $stmt_log->execute();
             $conn->commit();
             echo json_encode(["success" => true, "message" => "Η προσωρινή ανάθεση ακυρώθηκε επιτυχώς."]);
         } catch (Exception $e) { $conn->rollback(); echo json_encode(["success" => false, "message" => "Σφάλμα κατά την ακύρωση."]); }
         break;
    
    case 'cancel_after_2_years':
        if (!$is_supervisor) { exit(json_encode(["success" => false, "message" => "Permission denied."])); }
        $gs_number_year = $_POST['gs_number_year'] ?? '';
        if (empty($gs_number_year)) { exit(json_encode(["success" => false, "message" => "Ο αριθμός/έτος Γ.Σ. είναι υποχρεωτικός."])); }
        $stmt_date = $conn->prepare("SELECT assignment_date FROM theses WHERE id = ?");
        $stmt_date->bind_param("i", $thesis_id);
        $stmt_date->execute();
        $thesis_data = $stmt_date->get_result()->fetch_assoc();
        if (!$thesis_data || !$thesis_data['assignment_date']) { exit(json_encode(["success" => false, "message" => "Δεν βρέθηκε ημερομηνία ανάθεσης."])); }
        if ((new DateTime($thesis_data['assignment_date']))->diff(new DateTime())->y < 2) { exit(json_encode(["success" => false, "message" => "Η ακύρωση επιτρέπεται μόνο μετά την πάροδο 2 ετών."])); }

        $reason = "από Διδάσκοντα";
        $stmt_cancel = $conn->prepare("UPDATE theses SET status = 'cancelled', cancellation_reason = ?, gs_number = ? WHERE id = ?");
        $stmt_cancel->bind_param("ssi", $reason, $gs_number_year, $thesis_id);
        if ($stmt_cancel->execute()) {
            $stmt_log = $conn->prepare("INSERT INTO thesis_status_history (thesis_id, old_status, new_status) VALUES (?, 'active', 'cancelled')");
            $stmt_log->bind_param("i", $thesis_id);
            $stmt_log->execute();
            echo json_encode(["success" => true, "message" => "Η διπλωματική ακυρώθηκε επιτυχώς."]);
        } else { echo json_encode(["success" => false, "message" => "Σφάλμα κατά την ακύρωση."]); }
        break;


    default:
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Invalid or unknown action specified: '{$action}'."]);
        break;
}

$conn->close();

?>