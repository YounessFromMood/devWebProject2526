document.addEventListener('click', function (e) {

    if (e.target.closest('.btn-edit-student')) {
        const btn = e.target.closest('.btn-edit-student');

        document.getElementById('editStudentId').value     = btn.dataset.id;
        document.getElementById('editStudentPrenom').value = btn.dataset.prenom;
        document.getElementById('editStudentNom').value    = btn.dataset.nom;
        document.getElementById('editStudentEmail').value  = btn.dataset.email;
        document.getElementById('editStudentTel').value    = btn.dataset.tel;
        document.getElementById('editStudentMdp').value    = '';
        document.getElementById('editStudentError').classList.add('d-none');

        new bootstrap.Modal(document.getElementById('modalEditStudent')).show();
    }

    if (e.target.closest('.btn-delete-student')) {
        const btn = e.target.closest('.btn-delete-student');

        document.getElementById('deleteStudentId').value         = btn.dataset.id;
        document.getElementById('deleteStudentName').textContent = btn.dataset.nom;

        new bootstrap.Modal(document.getElementById('modalDeleteStudent')).show();
    }

    if (e.target.id === 'btnConfirmCreateStudent') {
        const errDiv = document.getElementById('createStudentError');
        const data = {
            prenom  : document.getElementById('createStudentPrenom').value.trim(),
            nom     : document.getElementById('createStudentNom').value.trim(),
            email   : document.getElementById('createStudentEmail').value.trim(),
            num_tel : document.getElementById('createStudentTel').value.trim(),
            mdp     : document.getElementById('createStudentMdp').value,
        };

        if (!data.prenom || !data.nom || !data.email || !data.mdp) {
            errDiv.textContent = 'Veuillez remplir tous les champs obligatoires.';
            errDiv.classList.remove('d-none');
            return;
        }

        fetch(BASE_URL + 'admin/student/create', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify(data)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalCreateStudent')).hide();
                showToast('Étudiant créé avec succès.');
                loadSection('etudiants', document.querySelector('[data-section="etudiants"]'));
            } else {
                errDiv.textContent = res.message ?? 'Une erreur est survenue.';
                errDiv.classList.remove('d-none');
            }
        })
        .catch(() => {
            errDiv.textContent = 'Erreur réseau.';
            errDiv.classList.remove('d-none');
        });
    }

    if (e.target.id === 'btnConfirmEditStudent') {
        const errDiv = document.getElementById('editStudentError');
        const id     = document.getElementById('editStudentId').value;
        const data = {
            prenom  : document.getElementById('editStudentPrenom').value.trim(),
            nom     : document.getElementById('editStudentNom').value.trim(),
            email   : document.getElementById('editStudentEmail').value.trim(),
            num_tel : document.getElementById('editStudentTel').value.trim(),
            mdp     : document.getElementById('editStudentMdp').value,
        };

        if (!data.prenom || !data.nom || !data.email) {
            errDiv.textContent = 'Prénom, nom et email sont obligatoires.';
            errDiv.classList.remove('d-none');
            return;
        }

        fetch(BASE_URL + 'admin/student/update', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify({ id_eleve: id, ...data })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalEditStudent')).hide();
                showToast('Étudiant mis à jour avec succès.');
                loadSection('etudiants', document.querySelector('[data-section="etudiants"]'));
            } else {
                errDiv.textContent = res.message ?? 'Une erreur est survenue.';
                errDiv.classList.remove('d-none');
            }
        })
        .catch(() => {
            errDiv.textContent = 'Erreur réseau.';
            errDiv.classList.remove('d-none');
        });
    }

    if (e.target.id === 'btnConfirmDeleteStudent') {
        const id = document.getElementById('deleteStudentId').value;

        fetch(BASE_URL + 'admin/student/delete', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify({ id_eleve: id })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalDeleteStudent')).hide();
                showToast('Étudiant supprimé avec succès.');
                loadSection('etudiants', document.querySelector('[data-section="etudiants"]'));
            }
        });
    }

    if (e.target.closest('#btnShowDeleted')) {
        fetch(BASE_URL + 'admin/student/deleted', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            const tbody = document.getElementById('deletedStudentsList');
            tbody.innerHTML = '';
            if (res.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Aucun étudiant supprimé.</td></tr>';
                return;
            }
            res.data.forEach(s => {
                tbody.innerHTML += `
                    <tr>
                        <td>${s.prenom}</td>
                        <td>${s.nom}</td>
                        <td>${s.email}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success btn-restore-student"
                                    data-id="${s.id_eleve}">
                                Rétablir
                            </button>
                        </td>
                    </tr>`;
            });
            new bootstrap.Modal(document.getElementById('modalDeletedStudents')).show();
        });
    }

    if (e.target.closest('.btn-restore-student')) {
        const btn = e.target.closest('.btn-restore-student');
        fetch(BASE_URL + 'admin/student/restore', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify({ id_eleve: btn.dataset.id })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                btn.closest('tr').remove();
                showToast('Étudiant rétabli avec succès.');
                loadSection('etudiants', document.querySelector('[data-section="etudiants"]'));
            }
        });
    }
});