document.addEventListener('click', function (e) {

    // Ouvrir la modale Lieu / Lien
    if (e.target.closest('.btn-manage-link')) {
        const btn       = e.target.closest('.btn-manage-link');
        const idSession = btn.dataset.idSession;
        const titre     = btn.dataset.titre;
        const lieu      = btn.dataset.lieu;

        document.getElementById('linkSessionId').value              = idSession;
        document.getElementById('linkSessionValue').value           = lieu;
        document.getElementById('modalSessionLinkSubtitle').textContent = titre;
        document.getElementById('sessionLinkError').classList.add('d-none');

        // Affiche ou cache le bouton Supprimer selon si un lien existe déjà
        document.getElementById('btnDeleteLink').style.display = lieu ? 'inline-block' : 'none';

        new bootstrap.Modal(document.getElementById('modalSessionLink')).show();
    }

    // Enregistrer (create ou update)
    if (e.target.id === 'btnConfirmSaveLink') {
        const errDiv    = document.getElementById('sessionLinkError');
        const idSession = document.getElementById('linkSessionId').value;
        const lieu      = document.getElementById('linkSessionValue').value.trim();
        const ancienLieu = document.querySelector(`.btn-manage-link[data-id-session="${idSession}"]`)?.dataset.lieu ?? '';

        if (!lieu) {
            errDiv.textContent = 'Le champ ne peut pas être vide.';
            errDiv.classList.remove('d-none');
            return;
        }

        const url = ancienLieu
            ? `${BASE_URL}teacher/session/link/modify-link/${idSession}/${encodeURIComponent(lieu)}`
            : `${BASE_URL}teacher/session/link/add-link/${idSession}/${encodeURIComponent(lieu)}`;

        fetch(url, {
            method  : 'POST',
            headers : { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalSessionLink')).hide();
                showToast('Lieu / lien enregistré avec succès.', 'success', () => {
                    loadSection('sessions', document.querySelector('[data-section="sessions"]'));
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

    // Supprimer le lien
    if (e.target.id === 'btnDeleteLink') {
        const idSession = document.getElementById('linkSessionId').value;

        fetch(`${BASE_URL}teacher/session/link/delete-link/${idSession}/delete`, {
            method  : 'POST',
            headers : { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalSessionLink')).hide();
                showToast('Lien supprimé avec succès.', 'success', () => {
                    loadSection('sessions', document.querySelector('[data-section="sessions"]'));
                });
            } else {
                showToast(res.message ?? 'Une erreur est survenue.', 'danger');
            }
        })
        .catch(() => showToast('Erreur réseau.', 'danger'));
    }
});