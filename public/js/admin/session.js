function loadSessions(idFormation) {
    const sectionAjax = document.getElementById('section-ajax');

    sectionAjax.style.opacity       = '0.4';
    sectionAjax.style.pointerEvents = 'none';

    fetch(BASE_URL + 'admin/session/index/' + idFormation, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.text())
    .then(html => {
        sectionAjax.innerHTML = html;
        sectionAjax.style.opacity       = '1';
        sectionAjax.style.pointerEvents = 'auto';

        sectionAjax.querySelectorAll('script').forEach(oldScript => {
            const newScript = document.createElement('script');
            newScript.textContent = oldScript.textContent;
            document.body.appendChild(newScript);
            document.body.removeChild(newScript);
        });

        if ($.fn.DataTable && $('#dataTableSessions').length) {
            if ($('#dataTableSessions tbody tr td').length > 1) {
                $('#dataTableSessions').DataTable({
                    columnDefs: [{
                        targets: '_all',
                        className: 'dt-head-left'
                    }]
                });
            } else {
                showToast('Aucune session pour cette formation pour le moment.', 'danger');
            }
        }

        populateSessionSelects();
    })
    .catch(() => {
        sectionAjax.innerHTML = '<div class="alert alert-danger">Impossible de charger les sessions.</div>';
        sectionAjax.style.opacity       = '1';
        sectionAjax.style.pointerEvents = 'auto';
    });
}

function populateSessionSelects() {
    const formateurs = window.SESSION_FORMATEURS ?? [];
    const modalites  = window.SESSION_MODALITES  ?? [];

    ['createSessionFormateur', 'editSessionFormateur'].forEach(id => {
        const sel = document.getElementById(id);
        if (!sel) return;
        sel.innerHTML = '<option value="">— Choisir un formateur —</option>';
        formateurs.forEach(f => {
            sel.innerHTML += `<option value="${f.id_formateur}">${f.prenom} ${f.nom}</option>`;
        });
    });

    ['createSessionModalite', 'editSessionModalite'].forEach(id => {
        const sel = document.getElementById(id);
        if (!sel) return;
        sel.innerHTML = '<option value="">— Choisir une modalité —</option>';
        modalites.forEach(m => {
            sel.innerHTML += `<option value="${m.id_modalite}">${m.libelle} (max ${m.nb_etudiant_max} élèves)</option>`;
        });
    });
}

function updateMaxInfo(selectId, infoId, valId) {
    const sel  = document.getElementById(selectId);
    const info = document.getElementById(infoId);
    const val  = document.getElementById(valId);
    if (!sel || !info || !val) return;

    const idModalite = parseInt(sel.value);
    const modalite   = (window.SESSION_MODALITES ?? []).find(m => parseInt(m.id_modalite) === idModalite);

    if (modalite) {
        val.textContent = modalite.nb_etudiant_max;
        info.classList.remove('d-none');
    } else {
        info.classList.add('d-none');
    }
}

document.addEventListener('change', function (e) {
    if (e.target.id === 'createSessionModalite') {
        updateMaxInfo('createSessionModalite', 'createSessionMaxInfo', 'createSessionMaxVal');
    }
    if (e.target.id === 'editSessionModalite') {
        updateMaxInfo('editSessionModalite', 'editSessionMaxInfo', 'editSessionMaxVal');
    }
});

document.addEventListener('click', function (e) {

    if (e.target.closest('#btnBackToFormations')) {
        loadSection('formations', document.querySelector('[data-section="formations"]'));
    }

    if (e.target.closest('.btn-manage-sessions')) {
        const btn = e.target.closest('.btn-manage-sessions');
        loadSessions(btn.dataset.id);
    }

    if (e.target.closest('.btn-edit-session')) {
        const btn = e.target.closest('.btn-edit-session');

        document.getElementById('editSessionId').value          = btn.dataset.id;
        document.getElementById('editSessionIdFormation').value = btn.dataset.formation;
        document.getElementById('editSessionDebut').value       = btn.dataset.debut;
        document.getElementById('editSessionFin').value         = btn.dataset.fin;
        document.getElementById('editSessionPrix').value        = btn.dataset.prix;
        document.getElementById('editSessionLieu').value        = btn.dataset.lieu;
        document.getElementById('editSessionError').classList.add('d-none');

        populateSessionSelects();

        setTimeout(() => {
            document.getElementById('editSessionFormateur').value = btn.dataset.formateur;
            document.getElementById('editSessionModalite').value  = btn.dataset.modalite;
            updateMaxInfo('editSessionModalite', 'editSessionMaxInfo', 'editSessionMaxVal');
        }, 50);

        new bootstrap.Modal(document.getElementById('modalEditSession')).show();
    }

    if (e.target.closest('.btn-delete-session')) {
        const btn = e.target.closest('.btn-delete-session');

        document.getElementById('deleteSessionId').value          = btn.dataset.id;
        document.getElementById('deleteSessionIdFormation').value = btn.dataset.formation;
        document.getElementById('deleteSessionDate').textContent  = btn.dataset.debut;

        new bootstrap.Modal(document.getElementById('modalDeleteSession')).show();
    }

    if (e.target.id === 'btnConfirmCreateSession') {
        const errDiv      = document.getElementById('createSessionError');
        const idFormation = window.CURRENT_ID_FORMATION;

        const data = {
            id_formation : idFormation,
            date_debut   : document.getElementById('createSessionDebut').value,
            date_fin     : document.getElementById('createSessionFin').value,
            id_formateur : document.getElementById('createSessionFormateur').value,
            id_modalite  : document.getElementById('createSessionModalite').value,
            prix         : document.getElementById('createSessionPrix').value  || null,
            lieu_session : document.getElementById('createSessionLieu').value  || null,
        };

        if (!data.date_debut || !data.date_fin || !data.id_formateur || !data.id_modalite) {
            errDiv.textContent = 'Veuillez remplir tous les champs obligatoires.';
            errDiv.classList.remove('d-none');
            return;
        }

        fetch(BASE_URL + 'admin/session/create', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify(data)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalCreateSession')).hide();
                showToast('Session créée avec succès.', 'success', () => {
                    loadSessions(idFormation);
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

    if (e.target.id === 'btnConfirmEditSession') {
        const errDiv      = document.getElementById('editSessionError');
        const idSession   = document.getElementById('editSessionId').value;
        const idFormation = document.getElementById('editSessionIdFormation').value;

        const data = {
            id_session   : idSession,
            date_debut   : document.getElementById('editSessionDebut').value,
            date_fin     : document.getElementById('editSessionFin').value,
            id_formateur : document.getElementById('editSessionFormateur').value,
            id_modalite  : document.getElementById('editSessionModalite').value,
            prix         : document.getElementById('editSessionPrix').value  || null,
            lieu_session : document.getElementById('editSessionLieu').value  || null,
        };

        if (!data.date_debut || !data.date_fin || !data.id_formateur || !data.id_modalite) {
            errDiv.textContent = 'Veuillez remplir tous les champs obligatoires.';
            errDiv.classList.remove('d-none');
            return;
        }

        fetch(BASE_URL + 'admin/session/update', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify(data)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalEditSession')).hide();
                showToast('Session mise à jour avec succès.', 'success', () => {
                    loadSessions(idFormation);
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

    if (e.target.id === 'btnConfirmDeleteSession') {
        const idSession   = document.getElementById('deleteSessionId').value;
        const idFormation = document.getElementById('deleteSessionIdFormation').value;

        fetch(BASE_URL + 'admin/session/delete', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify({ id_session: idSession })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalDeleteSession')).hide();
                showToast('Session supprimée avec succès.', 'success', () => {
                    loadSessions(idFormation);
                });
            }
        });
    }

    if (e.target.closest('#btnShowDeletedSessions')) {
        const btn         = e.target.closest('#btnShowDeletedSessions');
        const idFormation = btn.dataset.formation;

        fetch(BASE_URL + 'admin/session/deleted/' + idFormation, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.data.length === 0) {
                showToast('Aucune session supprimée pour le moment.', 'danger');
                return;
            }
            const tbody = document.getElementById('deletedSessionsList');
            tbody.innerHTML = '';
            res.data.forEach(s => {
                tbody.innerHTML += `
                    <tr>
                        <td>${s.date_debut}</td>
                        <td>${s.date_fin}</td>
                        <td>${s.formateur_prenom} ${s.formateur_nom}</td>
                        <td>${s.modalite_libelle}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success btn-restore-session"
                                    data-id="${s.id_session}"
                                    data-formation="${idFormation}">
                                Rétablir
                            </button>
                        </td>
                    </tr>`;
            });
            new bootstrap.Modal(document.getElementById('modalDeletedSessions')).show();
        });
    }

    if (e.target.closest('.btn-restore-session')) {
        const btn         = e.target.closest('.btn-restore-session');
        const idFormation = btn.dataset.formation;

        fetch(BASE_URL + 'admin/session/restore', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify({ id_session: btn.dataset.id })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                btn.closest('tr').remove();
                showToast('Session rétablie avec succès.', 'success', () => {
                    loadSessions(idFormation);
                });
            }
        });
    }
});

document.addEventListener('show.bs.modal', function (e) {
    if (e.target.id === 'modalCreateSession') {
        document.getElementById('createSessionDebut').value = '';
        document.getElementById('createSessionFin').value   = '';
        document.getElementById('createSessionPrix').value  = '';
        document.getElementById('createSessionLieu').value  = '';
        document.getElementById('createSessionError').classList.add('d-none');
        populateSessionSelects();
    }
});