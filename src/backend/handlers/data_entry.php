<?php
header('Content-Type: application/json');

session_start();

// Έλεγχος αν ο χρήστης είναι συνδεδεμένος και είναι γραμματεία
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'secretary') {
    echo json_encode(['success' => false, 'message' => 'Δεν έχετε δικαίωμα πρόσβασης']);
    exit();
}

// Στοιχεία σύνδεσης στη βάση δεδομένων (από το config.php)
require_once "../../config.php";

// Δημιουργία σύνδεσης
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Έλεγχος σύνδεσης
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Σφάλμα σύνδεσης στη βάση δεδομένων: " . $conn->connect_error]);
    exit();
}

// Έλεγχος αν έχει υποβληθεί αρχείο
if (!isset($_FILES['jsonFile'])) {
    echo json_encode(['success' => false, 'message' => 'Δεν έχει επιλεχθεί αρχείο']);
    exit();
}

// Έλεγχος για σφάλματα κατά το ανέβασμα
if ($_FILES['jsonFile']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Σφάλμα κατά το ανέβασμα του αρχείου']);
    exit();
}

// Έλεγχος τύπου αρχείου
$mimeType = mime_content_type($_FILES['jsonFile']['tmp_name']);
if ($mimeType !== 'application/json' && $mimeType !== 'text/plain') {
    echo json_encode(['success' => false, 'message' => 'Το αρχείο πρέπει να είναι τύπου JSON']);
    exit();
}

// Ορισμός του σταθερού κωδικού πρόσβασης για όλους τους χρήστες
$default_password = "upatras123";

// Hashing του προκαθορισμένου κωδικού μία φορά
$hashed_default_password = password_hash($default_password, PASSWORD_DEFAULT);

// Ανάγνωση του περιεχομένου του JSON αρχείου
$json_content = file_get_contents($_FILES['jsonFile']['tmp_name']);
if ($json_content === false) {
    echo json_encode(['success' => false, 'message' => 'Αδυναμία ανάγνωσης του αρχείου']);
    exit();
}

// Συνάρτηση για την επεξεργασία των χρηστών από το JSON
function importUsers($conn, $json_data, $hashed_password) {
    $data = json_decode($json_data, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['success' => false, 'message' => 'Σφάλμα: Μη έγκυρη μορφή JSON'];
    }

    if (!isset($data['students']) || !isset($data['professors'])) {
        return ['success' => false, 'message' => 'Σφάλμα: Τα κλειδιά "students" ή "professors" απουσιάζουν από το JSON'];
    }

    // Έλεγχος δομής δεδομένων
    foreach ($data['students'] as $student) {
        if (!isset($student['email']) || !isset($student['name']) || !isset($student['surname']) || 
            !isset($student['student_number'])) {
            return ['success' => false, 'message' => 'Σφάλμα: Ελλιπή στοιχεία φοιτητή'];
        }
    }

    foreach ($data['professors'] as $professor) {
        if (!isset($professor['email']) || !isset($professor['name']) || !isset($professor['surname'])) {
            return ['success' => false, 'message' => 'Σφάλμα: Ελλιπή στοιχεία καθηγητή'];
        }
    }

    // Έναρξη transaction
    $conn->begin_transaction();
    
    try {
        // Επεξεργασία των Φοιτητών
        foreach ($data['students'] as $student) {
            $username = $student['email'];
            $email = $student['email'];
            $role = 'student';
            
            // Εισαγωγή στον πίνακα users
            $stmt_users = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
            if (!$stmt_users) {
                throw new Exception("Σφάλμα προετοιμασίας SQL για τον πίνακα users: " . $conn->error);
            }
            
            $stmt_users->bind_param("ssss", $username, $hashed_password, $email, $role);
            if (!$stmt_users->execute()) {
                throw new Exception("Σφάλμα εισαγωγής χρήστη φοιτητή: " . $stmt_users->error);
            }
            $user_id = $conn->insert_id;
            
            // Εισαγωγή στον πίνακα students
            $stmt_students = $conn->prepare("INSERT INTO students (user_id, name, surname, student_number, street, number, city, postcode, father_name, landline_telephone, mobile_telephone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt_students) {
                throw new Exception("Σφάλμα προετοιμασίας SQL για τον πίνακα students: " . $conn->error);
            }
            
            $street = $student['street'] ?? '';
            $number = $student['number'] ?? '';
            $city = $student['city'] ?? '';
            $postcode = $student['postcode'] ?? '';
            $father_name = $student['father_name'] ?? '';
            $landline = $student['landline_telephone'] ?? '';
            $mobile = $student['mobile_telephone'] ?? '';
            
            $stmt_students->bind_param("isssssssiss", 
                $user_id,
                $student['name'],
                $student['surname'],
                $student['student_number'],
                $street,
                $number,
                $city,
                $postcode,
                $father_name,
                $landline,
                $mobile
            );
            if (!$stmt_students->execute()) {
                throw new Exception("Σφάλμα εισαγωγής στοιχείων φοιτητή: " . $stmt_students->error);
            }
            
            $stmt_students->close();
            $stmt_users->close();
        }
        
        // Επεξεργασία των Καθηγητών
        foreach ($data['professors'] as $professor) {
            $username = $professor['email'];
            $email = $professor['email'];
            $role = 'professor';
            
            // Εισαγωγή στον πίνακα users
            $stmt_users = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
            if (!$stmt_users) {
                throw new Exception("Σφάλμα προετοιμασίας SQL για τον πίνακα users: " . $conn->error);
            }
            
            $stmt_users->bind_param("ssss", $username, $hashed_password, $email, $role);
            if (!$stmt_users->execute()) {
                throw new Exception("Σφάλμα εισαγωγής χρήστη καθηγητή: " . $stmt_users->error);
            }
            $user_id = $conn->insert_id;
            
            // Εισαγωγή στον πίνακα professors
            $stmt_professors = $conn->prepare("INSERT INTO professors (user_id, name, surname, topic, landline, mobile, department, university) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt_professors) {
                throw new Exception("Σφάλμα προετοιμασίας SQL για τον πίνακα professors: " . $conn->error);
            }
            
            $topic = $professor['topic'] ?? '';
            $landline = $professor['landline'] ?? '';
            $mobile = $professor['mobile'] ?? '';
            $department = $professor['department'] ?? '';
            $university = $professor['university'] ?? '';
            
            $stmt_professors->bind_param("isssssss", 
                $user_id,
                $professor['name'],
                $professor['surname'],
                $topic,
                $landline,
                $mobile,
                $department,
                $university
            );
            if (!$stmt_professors->execute()) {
                throw new Exception("Σφάλμα εισαγωγής στοιχείων καθηγητή: " . $stmt_professors->error);
            }
            
            $stmt_professors->close();
            $stmt_users->close();
        }
        
        // Ολοκλήρωση transaction
        $conn->commit();
        return ['success' => true, 'message' => 'Επιτυχής εισαγωγή δεδομένων'];
        
    } catch (Exception $e) {
        // Rollback σε περίπτωση σφάλματος
        $conn->rollback();
        return ['success' => false, 'message' => 'Σφάλμα κατά την εισαγωγή: ' . $e->getMessage()];
    }
}

// Εισαγωγή των δεδομένων
$result = importUsers($conn, $json_content, $hashed_default_password);
echo json_encode($result);