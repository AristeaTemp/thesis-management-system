<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Ορίζουμε τους τίτλους για κάθε σελίδα
$page_titles = [
    'home' => 'Αρχική Σελίδα',
    'student_view_thesis' => 'Προβολή Θέματος',
    'student_manage_thesis' => 'Διαχείριση Διπλωματικής',
    'student_edit_profile' => 'Επεξεργασία Προφίλ',
    'manage_topics' => 'Διαχείριση Θεμάτων',
    'assign_topic' => 'Ανάθεση Θέματος',
    'view_theses' => 'Προβολή Διπλωματικών',
    'view_invitations' => 'Προσκλήσεις',
    'view_stats' => 'Στατιστικά',
    'edit_topic' => 'Επεξεργασία Θέματος',
    'data_entry' => 'Εισαγωγή Δεδομένων',
    'manage_thesis' => 'Διαχείριση Διπλωματικής',
    'view_thesis_details' => 'Λεπτομέρειες Διπλωματικής'
];
$page = $_GET['page'] ?? 'home';
$current_title = $page_titles[$page] ?? 'Σύστημα Διπλωματικών';

?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($current_title); ?></title>
    
    <link href="https://bootswatch.com/5/united/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;700&display=swap');

        body {
            font-family: 'Public Sans', sans-serif;
            background: linear-gradient(to bottom, #ffffff, #f7f9fc);
        }

        .navbar {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* Διορθώνει το χρώμα του ενεργού link για να ταιριάζει με το θέμα */
        .navbar-dark .navbar-nav .nav-link.active {
            color: #ffffff;
            font-weight: bold;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .card, .jumbotron {
            animation: fadeIn 0.5s ease-out forwards;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .action-card {
            transition: all 0.2s ease-in-out;
        }
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }
        .action-card .icon {
            font-size: 3rem;
            color: #e95420; /* Πορτοκαλί χρώμα του θέματος */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php"><i class="bi bi-mortarboard-fill"></i> Σύστημα Διπλωματικών</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php
            // Δυναμική επισήμανση του ενεργού link στο μενού
            if ($_SESSION['role'] === 'student') {
                echo '<li class="nav-item"><a class="nav-link ' . ($page === 'student_view_thesis' ? 'active' : '') . '" href="?page=student_view_thesis">Η Διπλωματική μου</a></li>';
                echo '<li class="nav-item"><a class="nav-link ' . ($page === 'student_manage_thesis' ? 'active' : '') . '" href="?page=student_manage_thesis">Διαχείριση</a></li>';
                echo '<li class="nav-item"><a class="nav-link ' . ($page === 'student_edit_profile' ? 'active' : '') . '" href="?page=student_edit_profile">Προφίλ</a></li>';
            } elseif ($_SESSION['role'] === 'professor') {
                echo '<li class="nav-item"><a class="nav-link ' . (in_array($page, ['manage_topics', 'edit_topic']) ? 'active' : '') . '" href="?page=manage_topics">Θέματα</a></li>';
                echo '<li class="nav-item"><a class="nav-link ' . ($page === 'assign_topic' ? 'active' : '') . '" href="?page=assign_topic">Ανάθεση</a></li>';
                echo '<li class="nav-item"><a class="nav-link ' . (in_array($page, ['view_theses', 'view_thesis_details']) ? 'active' : '') . '" href="?page=view_theses">Διπλωματικές</a></li>';
                echo '<li class="nav-item"><a class="nav-link ' . ($page === 'view_invitations' ? 'active' : '') . '" href="?page=view_invitations">Προσκλήσεις</a></li>';
                echo '<li class="nav-item"><a class="nav-link ' . ($page === 'view_stats' ? 'active' : '') . '" href="?page=view_stats">Στατιστικά</a></li>';
            } elseif ($_SESSION['role'] === 'secretary') {
                echo '<li class="nav-item"><a class="nav-link ' . (in_array($page, ['view_theses', 'manage_thesis']) ? 'active' : '') . '" href="?page=view_theses">Προβολή ΔΕ</a></li>';
                echo '<li class="nav-item"><a class="nav-link ' . ($page === 'data_entry' ? 'active' : '') . '" href="?page=data_entry">Εισαγωγή</a></li>';
            }
            ?>
          </ul>
          <a class="btn btn-primary" href="logout.php"><i class="bi bi-box-arrow-right"></i> Αποσύνδεση</a>
        </div>
      </div>
    </nav>
    
    <main class="container mt-4 mb-4">
        <?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
        <div class="alert alert-<?php echo $_GET['status'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php
        $page_to_load = $_GET['page'] ?? 'home';

        if ($page_to_load === 'home') {
            echo '<div class="row align-items-center jumbotron">';
            echo '  <div class="col-md-7">';
            echo '    <h1 class="display-4 fw-bold" id="welcome-message">Καλωσόρισες!</h1>';
            echo '    <p class="fs-4 text-muted">Καλωσήρθατε στο Σύστημα Υποστήριξης Διπλωματικών Εργασιών. Από εδώ μπορείτε να διαχειριστείτε όλες τις σχετικές διαδικασίες.</p>';
            echo '  </div>';
            echo '  <div class="col-md-5">';
            if ($_SESSION['role'] === 'professor') {
                echo '  <div class="card action-card mb-3"><a href="?page=manage_topics" class="text-decoration-none text-dark"><div class="card-body text-center p-4"><div class="icon"><i class="bi bi-plus-square-fill"></i></div><h5 class="card-title mt-2">Διαχείριση Θεμάτων</h5><p class="card-text">Δημιουργήστε και επεξεργαστείτε τα θέματά σας.</p></div></a></div>';
                echo '  <div class="card action-card"><a href="?page=view_theses" class="text-decoration-none text-dark"><div class="card-body text-center p-4"><div class="icon"><i class="bi bi-list-task"></i></div><h5 class="card-title mt-2">Οι Διπλωματικές μου</h5><p class="card-text">Δείτε όλες τις διπλωματικές που επιβλέπετε.</p></div></a></div>';
            } elseif ($_SESSION['role'] === 'student') {
                echo '  <div class="card action-card mb-3"><a href="?page=student_view_thesis" class="text-decoration-none text-dark"><div class="card-body text-center p-4"><div class="icon"><i class="bi bi-book-fill"></i></div><h5 class="card-title mt-2">Η Διπλωματική μου</h5><p class="card-text">Δείτε τις λεπτομέρειες της διπλωματικής σας.</p></div></a></div>';
                echo '  <div class="card action-card"><a href="?page=student_manage_thesis" class="text-decoration-none text-dark"><div class="card-body text-center p-4"><div class="icon"><i class="bi bi-people-fill"></i></div><h5 class="card-title mt-2">Διαχείριση Επιτροπής</h5><p class="card-text">Στείλτε προσκλήσεις και ανεβάστε υλικό.</p></div></a></div>';
            } elseif ($_SESSION['role'] === 'secretary') {
                echo '  <div class="card action-card mb-3"><a href="?page=view_theses" class="text-decoration-none text-dark"><div class="card-body text-center p-4"><div class="icon"><i class="bi bi-card-list"></i></div><h5 class="card-title mt-2">Προβολή Διπλωματικών</h5><p class="card-text">Δείτε και διαχειριστείτε όλες τις ενεργές διπλωματικές.</p></div></a></div>';
                echo '  <div class="card action-card"><a href="?page=data_entry" class="text-decoration-none text-dark"><div class="card-body text-center p-4"><div class="icon"><i class="bi bi-cloud-upload-fill"></i></div><h5 class="card-title mt-2">Εισαγωγή Δεδομένων</h5><p class="card-text">Εισάγετε μαζικά δεδομένα φοιτητών και διδασκόντων.</p></div></a></div>';
            }
            echo '  </div>';
            echo '</div>';
        } else {
          
            echo '<div class="card border-0 shadow-sm">';
            echo '  <div class="card-header bg-light border-0"><h4 class="mb-0">' . htmlspecialchars($current_title) . '</h4></div>';
            echo '  <div class="card-body p-4">';
            switch ($page_to_load) {
                case 'manage_topics': include 'frontend/professor/professor_manage_topics.html'; break;
                case 'assign_topic': include 'frontend/professor/professor_assign_topic.html'; break;
                case 'view_theses':
                    if ($_SESSION['role'] === 'professor') { include 'frontend/professor/professor_view_theses.html'; } 
                    elseif ($_SESSION['role'] === 'secretary') { include 'frontend/secretary/secretary_view_theses.html'; }
                    break; 
                case 'view_invitations': include 'frontend/professor/professor_view_invitations.html'; break;
                case 'view_stats': include 'frontend/professor/professor_view_stats.html'; break;
                case 'edit_topic': include 'frontend/professor/professor_edit_topic.html'; break;
                case 'data_entry': include 'frontend/secretary/secretary_data_entry.html'; break;
                case 'manage_thesis': include 'frontend/secretary/secretary_manage_thesis.html';  break;
                case 'student_view_thesis': include 'frontend/student/student_view_thesis.html'; break;
                case 'student_manage_thesis': include 'frontend/student/student_manage_thesis.html'; break;
                case 'student_edit_profile': include 'frontend/student/student_edit_profile.html'; break;
                case 'view_thesis_details': include 'frontend/professor/professor_view_thesis_details.html'; break;
                default:
                    echo "<p>Η σελίδα δεν βρέθηκε.</p>";
                    break;
            }
            echo '  </div>';
            echo '</div>';
        }
        ?>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const welcomeMessage = document.getElementById('welcome-message');
        if (welcomeMessage) {
            fetch('backend/api/get_user_name.php').then(res => res.json()).then(data => {
                if (data.name) {
                    welcomeMessage.textContent = `Καλωσόρισες, ${data.name}!`;
                }
            });
        }
    });
    </script>
</body>
</html>