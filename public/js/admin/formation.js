function renderTypeCheckboxes(containerId, selectedIds = []) {
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    TYPES_FORMATION.forEach(type => {
        const checked = selectedIds.includes(parseInt(type.id_type_formation)) ? 'checked' : '';
        container.innerHTML += `
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="${type.id_type_formation}"
                       id="${containerId}_type_${type.id_type_formation}" ${checked}>
                <label class="form-check-label" for="${containerId}_type_${type.id_type_formation}">
                    ${type.libelle}
                </label>
            </div>`;
    });
}

function getCheckedTypes(containerId) {
    return Array.from(document.querySelectorAll(`#${containerId} input[type=checkbox]:checked`))
        .map(cb => parseInt(cb.value));
}

document.addEventListener('click', function (e) {

    if (e.target.closest('.btn-edit-formation')) {
        const btn = e.target.closest('.btn-edit-formation');

        document.getElementById('editFormationId').value          = btn.dataset.id;
        document.getElementById('editFormationTitre').value       = btn.dataset.titre;
        document.getElementById('editFormationDescription').value = btn.dataset.description;
        document.getElementById('editFormationDuree').value       = btn.dataset.duree;
        document.getElementById('editFormationPrix').value        = btn.dataset.prix;
        document.getElementById('editFormationLangue').value      = btn.dataset.langue;
        document.getElementById('editFormationError').classList.add('d-none');

        fetch(BASE_URL + 'admin/formation/types/' + btn.dataset.id, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            const selectedIds = res.data.map(t => parseInt(t.id_type_formation));
            renderTypeCheckboxes('editFormationTypes', selectedIds);
        });

        new bootstrap.Modal(document.getElementById('modalEditFormation')).show();
    }

    if (e.target.closest('.btn-delete-formation')) {
        const btn = e.target.closest('.btn-delete-formation');

        document.getElementById('deleteFormationId').value          = btn.dataset.id;
        document.getElementById('deleteFormationTitre').textContent = btn.dataset.titre;

        new bootstrap.Modal(document.getElementById('modalDeleteFormation')).show();
    }

    if (e.target.id === 'btnConfirmCreateFormation') {
        const errDiv = document.getElementById('createFormationError');
        const data = {
            titre       : document.getElementById('createFormationTitre').value.trim(),
            description : document.getElementById('createFormationDescription').value.trim(),
            duree       : document.getElementById('createFormationDuree').value.trim(),
            prix        : document.getElementById('createFormationPrix').value.trim(),
            langue      : document.getElementById('createFormationLangue').value.trim(),
            types       : getCheckedTypes('createFormationTypes'),
        };

        if (!data.titre || !data.description) {
            errDiv.textContent = 'Le titre et la description sont obligatoires.';
            errDiv.classList.remove('d-none');
            return;
        }

        fetch(BASE_URL + 'admin/formation/create', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify(data)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalCreateFormation')).hide();
                showToast('Formation créée avec succès.');
                loadSection('formations', document.querySelector('[data-section="formations"]'));
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

    if (e.target.id === 'btnConfirmEditFormation') {
        const errDiv = document.getElementById('editFormationError');
        const data = {
            id_formation : document.getElementById('editFormationId').value,
            titre        : document.getElementById('editFormationTitre').value.trim(),
            description  : document.getElementById('editFormationDescription').value.trim(),
            duree        : document.getElementById('editFormationDuree').value.trim(),
            prix         : document.getElementById('editFormationPrix').value.trim(),
            langue       : document.getElementById('editFormationLangue').value.trim(),
            types        : getCheckedTypes('editFormationTypes'),
        };

        if (!data.titre || !data.description) {
            errDiv.textContent = 'Le titre et la description sont obligatoires.';
            errDiv.classList.remove('d-none');
            return;
        }

        fetch(BASE_URL + 'admin/formation/update', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify(data)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalEditFormation')).hide();
                showToast('Formation mise à jour avec succès.');
                loadSection('formations', document.querySelector('[data-section="formations"]'));
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

    if (e.target.id === 'btnConfirmDeleteFormation') {
        const id = document.getElementById('deleteFormationId').value;

        fetch(BASE_URL + 'admin/formation/delete', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify({ id_formation: id })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalDeleteFormation')).hide();
                showToast('Formation supprimée avec succès.');
                loadSection('formations', document.querySelector('[data-section="formations"]'));
            }
        });
    }

    if (e.target.closest('#btnShowDeletedFormations')) {
        fetch(BASE_URL + 'admin/formation/deleted', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            const tbody = document.getElementById('deletedFormationsList');
            tbody.innerHTML = '';
            if (res.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Aucune formation supprimée.</td></tr>';
                return;
            }
            res.data.forEach(f => {
                tbody.innerHTML += `
                    <tr>
                        <td>${f.titre}</td>
                        <td>${f.duree ?? '—'}</td>
                        <td>${f.prix ? f.prix + ' €' : '—'}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success btn-restore-formation"
                                    data-id="${f.id_formation}">
                                Rétablir
                            </button>
                        </td>
                    </tr>`;
            });
            new bootstrap.Modal(document.getElementById('modalDeletedFormations')).show();
        });
    }

    if (e.target.closest('.btn-restore-formation')) {
        const btn = e.target.closest('.btn-restore-formation');
        fetch(BASE_URL + 'admin/formation/restore', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify({ id_formation: btn.dataset.id })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                btn.closest('tr').remove();
                showToast('Formation rétablie avec succès.');
                loadSection('formations', document.querySelector('[data-section="formations"]'));
            }
        });
    }
});

document.addEventListener('show.bs.modal', function (e) {
    if (e.target.id === 'modalCreateFormation') {
        if (typeof TYPES_FORMATION === 'undefined') return;
        renderTypeCheckboxes('createFormationTypes');
        document.getElementById('createFormationTitre').value       = '';
        document.getElementById('createFormationDescription').value = '';
        document.getElementById('createFormationDuree').value       = '';
        document.getElementById('createFormationPrix').value        = '';
        document.getElementById('createFormationLangue').value      = '';
        document.getElementById('createFormationError').classList.add('d-none');
    }
});