/**
 * Recharge le tableau des étudiants à l'intérieur de la modale #modalSessionStudents.
 * Appelé après chaque opération sur une note pour refléter l'état réel en BDD.
 */
function reloadStudentsList(idSession) {
    fetch(BASE_URL + 'teacher/sessions/students/' + idSession, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(res => {
        if (!res.success) return;

        const tbody = document.getElementById('sessionStudentsList');
        tbody.innerHTML = '';

        if (res.data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Aucun étudiant inscrit.</td></tr>';
            return;
        }

        res.data.forEach(s => {
            const noteLabel = s.note_libelle
                ? `<span class="badge text-white" style="background-color: #e8630a;">${s.note_libelle}</span>`
                : '<span class="text-muted">—</span>';

            const actionsBtns = s.note_libelle
                ? `<button class="btn btn-sm btn-outline-secondary btn-edit-grade"
                           data-id-session="${idSession}"
                           data-id-eleve="${s.id_eleve}"
                           data-nom="${s.prenom} ${s.nom}"
                           data-note="${s.note_libelle}">
                       Modifier
                   </button>
                   <button class="btn btn-sm btn-outline-danger btn-delete-grade"
                           data-id-session="${idSession}"
                           data-id-eleve="${s.id_eleve}"
                           data-nom="${s.prenom} ${s.nom}">
                       Supprimer
                   </button>`
                : `<button class="btn btn-sm text-white btn-create-grade"
                           style="background-color: #e8630a;"
                           data-id-session="${idSession}"
                           data-id-eleve="${s.id_eleve}"
                           data-nom="${s.prenom} ${s.nom}">
                       Attribuer une note
                   </button>`;

            tbody.innerHTML += `
                <tr>
                    <td>${s.prenom}</td>
                    <td>${s.nom}</td>
                    <td>${s.email}</td>
                    <td>${noteLabel}</td>
                    <td>${actionsBtns}</td>
                </tr>`;
        });
    })
    .catch(() => showToast('Impossible de recharger la liste des étudiants.', 'danger'));
}

document.addEventListener('click', function (e) {

    // Ouvrir la modale liste étudiants
    if (e.target.closest('.btn-view-students')) {
        const btn       = e.target.closest('.btn-view-students');
        const idSession = btn.dataset.idSession;
        const titre     = btn.dataset.titre;

        document.getElementById('currentSessionId').value           = idSession;
        document.getElementById('modalSessionStudentsSubtitle').textContent = titre;

        reloadStudentsList(idSession);

        new bootstrap.Modal(document.getElementById('modalSessionStudents')).show();
    }

    // Attribuer une note
    if (e.target.closest('.btn-create-grade')) {
        const btn = e.target.closest('.btn-create-grade');

        document.getElementById('createGradeIdSession').value      = btn.dataset.idSession;
        document.getElementById('createGradeIdEleve').value        = btn.dataset.idEleve;
        document.getElementById('createGradeEtudiantName').textContent = btn.dataset.nom;
        document.getElementById('createGradeNote').value           = '';
        document.getElementById('createGradeError').classList.add('d-none');

        new bootstrap.Modal(document.getElementById('modalCreateGrade')).show();
    }

    if (e.target.id === 'btnConfirmCreateGrade') {
        const errDiv    = document.getElementById('createGradeError');
        const idSession = document.getElementById('createGradeIdSession').value;
        const idEleve   = document.getElementById('createGradeIdEleve').value;
        const note      = document.getElementById('createGradeNote').value;

        if (!note) {
            errDiv.textContent = 'Veuillez choisir une note.';
            errDiv.classList.remove('d-none');
            return;
        }

        fetch(`${BASE_URL}teacher/grades/create/${idSession}/${idEleve}/${encodeURIComponent(note)}`, {
            method  : 'POST',
            headers : { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalCreateGrade')).hide();
                showToast('Note attribuée avec succès.', 'success');
                reloadStudentsList(idSession);
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

    // Modifier une note
    if (e.target.closest('.btn-edit-grade')) {
        const btn = e.target.closest('.btn-edit-grade');

        document.getElementById('editGradeIdSession').value         = btn.dataset.idSession;
        document.getElementById('editGradeIdEleve').value           = btn.dataset.idEleve;
        document.getElementById('editGradeEtudiantName').textContent = btn.dataset.nom;
        document.getElementById('editGradeNote').value              = btn.dataset.note;
        document.getElementById('editGradeError').classList.add('d-none');

        new bootstrap.Modal(document.getElementById('modalEditGrade')).show();
    }

    if (e.target.id === 'btnConfirmEditGrade') {
        const errDiv    = document.getElementById('editGradeError');
        const idSession = document.getElementById('editGradeIdSession').value;
        const idEleve   = document.getElementById('editGradeIdEleve').value;
        const note      = document.getElementById('editGradeNote').value;

        if (!note) {
            errDiv.textContent = 'Veuillez choisir une note.';
            errDiv.classList.remove('d-none');
            return;
        }

        fetch(`${BASE_URL}teacher/grades/update/${idSession}/${idEleve}/${encodeURIComponent(note)}`, {
            method  : 'POST',
            headers : { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalEditGrade')).hide();
                showToast('Note modifiée avec succès.', 'success');
                reloadStudentsList(idSession);
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

    // Supprimer une note
    if (e.target.closest('.btn-delete-grade')) {
        const btn = e.target.closest('.btn-delete-grade');

        document.getElementById('deleteGradeIdSession').value           = btn.dataset.idSession;
        document.getElementById('deleteGradeIdEleve').value             = btn.dataset.idEleve;
        document.getElementById('deleteGradeEtudiantName').textContent  = btn.dataset.nom;

        new bootstrap.Modal(document.getElementById('modalDeleteGrade')).show();
    }

    if (e.target.id === 'btnConfirmDeleteGrade') {
        const idSession = document.getElementById('deleteGradeIdSession').value;
        const idEleve   = document.getElementById('deleteGradeIdEleve').value;

        fetch(`${BASE_URL}teacher/grades/delete/${idSession}/${idEleve}/delete`, {
            method  : 'POST',
            headers : { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalDeleteGrade')).hide();
                showToast('Note supprimée avec succès.', 'success');
                reloadStudentsList(idSession);
            } else {
                showToast(res.message ?? 'Une erreur est survenue.', 'danger');
            }
        })
        .catch(() => showToast('Erreur réseau.', 'danger'));
    }
});