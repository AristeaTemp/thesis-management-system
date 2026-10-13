<!-- Σελίδα προβολής λεπτομερειών διπλωματικής εργασίας για φοιτητή -->
<h3>Προβολή Θέματος Διπλωματικής Εργασίας</h3>
<div id="thesis-details-container">
    <p>Φόρτωση πληροφοριών...</p>
</div>

<script>
// Αρχικοποίηση σελίδας - φόρτωση λεπτομερειών διπλωματικής εργασίας
document.addEventListener('DOMContentLoaded', function() {
    // Κλήση API για λήψη λεπτομερειών διπλωματικής εργασίας
    fetch('backend/api/student_view_thesis.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('thesis-details-container');
            if (data.error) {
                container.innerHTML = `<div class="alert alert-warning">${data.error}</div>`;
            } else {
                let committeeHTML = '<h5>Τριμελής Επιτροπή</h5>';
                if (data.committee && data.committee.length > 0) {
                    committeeHTML += '<ul class="list-group">';
                    data.committee.forEach(member => {
                        committeeHTML += `<li class="list-group-item">${member.name} ${member.surname} - <strong>${member.role === 'supervisor' ? 'Επιβλέπων' : 'Μέλος'}</strong></li>`;
                    });
                    committeeHTML += '</ul>';
                } else {
                    committeeHTML += '<p>Η επιτροπή δεν έχει οριστεί ακόμα.</p>';
                }

                let timeElapsedHTML = '';
                if (data.assignment_date) {
                    const assignmentDate = new Date(data.assignment_date);
                    const now = new Date();
                    const diffTime = Math.abs(now - assignmentDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    timeElapsedHTML = `<p class="mt-3"><strong>Χρόνος από την ανάθεση:</strong> ${diffDays} ημέρες</p>`;
                }

                container.innerHTML = `
                    <div class="card">
                        <div class="card-header">
                            <h4>${data.title}</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Κατάσταση:</strong> <span class="badge ${getStatusBadgeClass(data.status)}">${data.status.replace('_', ' ')}</span></p>
                            <p><strong>Περιγραφή:</strong> ${data.description}</p>
                            ${data.final_text_link ? `<p><strong>Αρχείο Περιγραφής:</strong> <a href="backend/api/view_topic_file.php?topic_id=${data.id}" target="_blank">Προβολή PDF</a></p>` : ''}
                            ${data.draft_file_path ? `<p><strong>Πρόχειρο Κείμενο:</strong> <a href="backend/api/student_view_draft_file.php?thesis_id=${data.id}" target="_blank">Προβολή PDF</a></p>` : ''}
                            <hr>
                            ${committeeHTML}
                            ${timeElapsedHTML}
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Σφάλμα:', error);
            document.getElementById('thesis-details-container').innerHTML = '<div class="alert alert-danger">Παρουσιάστηκε σφάλμα κατά την ανάκτηση των δεδομένων.</div>';
        });
});

function getStatusBadgeClass(status) {
    const statusClasses = {
        'under_assignment': 'bg-warning text-dark',
        'active': 'bg-success',
        'under_review': 'bg-info text-dark',
        'completed': 'bg-primary',
        'cancelled': 'bg-danger'
    };
    return statusClasses[status] || 'bg-secondary';
}
</script>
