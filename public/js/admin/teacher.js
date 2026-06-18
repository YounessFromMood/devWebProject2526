document.addEventListener('click', function (e) {

    if (e.target.closest('.btn-edit-teacher')) {
        const btn = e.target.closest('.btn-edit-teacher');

        document.getElementById('editId').value     = btn.dataset.id;
        document.getElementById('editPrenom').value = btn.dataset.prenom;
        document.getElementById('editNom').value    = btn.dataset.nom;
        document.getElementById('editEmail').value  = btn.dataset.email;
        document.getElementById('editTel').value    = btn.dataset.tel;
        document.getElementById('editTeacherError').classList.add('d-none');

        new bootstrap.Modal(document.getElementById('modalEditTeacher')).show();
    }

    if (e.target.closest('.btn-delete-teacher')) {
        const btn = e.target.closest('.btn-delete-teacher');

        document.getElementById('deleteId').value         = btn.dataset.id;
        document.getElementById('deleteTeacherName').textContent = btn.dataset.nom;

        new bootstrap.Modal(document.getElementById('modalDeleteTeacher')).show();
    }

    if (e.target.id === 'btnConfirmCreate') {
        const errDiv = document.getElementById('createTeacherError');
        const data = {
            prenom  : document.getElementById('createPrenom').value.trim(),
            nom     : document.getElementById('createNom').value.trim(),
            email   : document.getElementById('createEmail').value.trim(),
            num_tel : document.getElementById('createTel').value.trim(),
            mdp     : document.getElementById('createMdp').value,
        };

        if (!data.prenom || !data.nom || !data.email || !data.mdp) {
            errDiv.textContent = 'Veuillez remplir tous les champs obligatoires.';
            errDiv.classList.remove('d-none');
            return;
        }

        fetch(BASE_URL + 'admin/teacher/create', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify(data)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalCreateTeacher')).hide();
                showToast('Formateur créé avec succès.', 'success', () => {
                    loadSection('formateurs', document.querySelector('[data-section="formateurs"]'));
                });
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

    if (e.target.id === 'btnConfirmEdit') {
        const errDiv = document.getElementById('editTeacherError');
        const id     = document.getElementById('editId').value;
        const data = {
            prenom  : document.getElementById('editPrenom').value.trim(),
            nom     : document.getElementById('editNom').value.trim(),
            email   : document.getElementById('editEmail').value.trim(),
            num_tel : document.getElementById('editTel').value.trim(),
        };

        if (!data.prenom || !data.nom || !data.email) {
            errDiv.textContent = 'Prénom, nom et email sont obligatoires.';
            errDiv.classList.remove('d-none');
            return;
        }

        fetch(BASE_URL + 'admin/teacher/update', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify({ id, ...data })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalEditTeacher')).hide();
                showToast('Formateur mis à jour avec succès.', 'success', () => {
                    loadSection('formateurs', document.querySelector('[data-section="formateurs"]'));
                });
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

    if (e.target.id === 'btnConfirmDelete') {
        const id = document.getElementById('deleteId').value;

        fetch(BASE_URL + 'admin/teacher/delete', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify({ id })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalDeleteTeacher')).hide();
                showToast('Formateur supprimé avec succès.', 'success', () => {
                    loadSection('formateurs', document.querySelector('[data-section="formateurs"]'));
                });
            }
        });
    }

    if (e.target.closest('#btnShowDeletedTeachers')) {
        fetch(BASE_URL + 'admin/teacher/deleted', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.data.length === 0) {
                showToast('Aucun formateur n\'a été supprimé pour le moment.', 'danger');
                return;
            }
            const tbody = document.getElementById('deletedTeachersList');
            tbody.innerHTML = '';
            res.data.forEach(t => {
                tbody.innerHTML += `
                    <tr>
                        <td>${t.prenom}</td>
                        <td>${t.nom}</td>
                        <td>${t.email}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success btn-restore-teacher"
                                    data-id="${t.id_formateur}">
                                Rétablir
                            </button>
                        </td>
                    </tr>`;
            });
            new bootstrap.Modal(document.getElementById('modalDeletedTeachers')).show();
        });
    }

    if (e.target.closest('.btn-restore-teacher')) {
        const btn = e.target.closest('.btn-restore-teacher');
        fetch(BASE_URL + 'admin/teacher/restore', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify({ id: btn.dataset.id })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                btn.closest('tr').remove();
                showToast('Formateur rétabli avec succès.', 'success', () => {
                    loadSection('formateurs', document.querySelector('[data-section="formateurs"]'));
                });
            }
        });
    }
});