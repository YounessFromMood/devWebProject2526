document.addEventListener('click', function (e) {

    if (e.target.closest('.btn-view-students')) {
        const btn       = e.target.closest('.btn-view-students');
        const idSession = btn.dataset.idSession;
        const titre     = btn.dataset.titre;

        document.getElementById('studentsSessionTitle').textContent = titre;
        document.getElementById('studentsSessionError').classList.add('d-none');

        fetch(`${BASE_URL}teacher/sessions/students/${idSession}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                const tbody = document.getElementById('studentsList');
                tbody.innerHTML = '';
                res.data.forEach(s => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${s.prenom}</td>
                            <td>${s.nom}</td>
                            <td>${s.email}</td>
                        </tr>`;
                });
                new bootstrap.Modal(document.getElementById('modalStudents')).show();
            }
        })
        .catch(() => showToast('Erreur réseau.', 'danger'));
    }

});