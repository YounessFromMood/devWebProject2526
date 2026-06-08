const sectionProfil = document.getElementById('section-profil');
const sectionAjax   = document.getElementById('section-ajax');
const sidebarLinks  = document.querySelectorAll('.sidebar-link');

function setActiveLink(activeLink) {
    sidebarLinks.forEach(link => {
        link.classList.remove('active');
        link.style.backgroundColor = '';
        link.style.color = '#ccc';
    });
    activeLink.classList.add('active');
    activeLink.style.backgroundColor = '#e8630a';
    activeLink.style.color = '#fff';
}

function loadSection(section, link) {
    setActiveLink(link);

    if (section === 'profil') {
        sectionProfil.style.display = 'block';
        sectionAjax.style.display   = 'none';
        sectionAjax.innerHTML       = '';
        return;
    }

    sectionProfil.style.display = 'none';
    sectionAjax.style.display   = 'block';

    // ✅ Au lieu de vider la liste (ce qui cause le clignotement),
    // on réduit juste l'opacité pour indiquer visuellement que ça charge.
    // La liste reste visible mais légèrement transparente.
    sectionAjax.style.opacity       = '0.4';
    sectionAjax.style.pointerEvents = 'none'; // désactive les clics pendant le chargement

    const urls = {
        'etudiants'  : BASE_URL + 'admin/student/index',
        'formateurs' : BASE_URL + 'admin/teacher/index',
        'formations' : BASE_URL + 'admin/formation/index',
        'paiements'  : BASE_URL + 'admin/payment',
    };

    fetch(urls[section], {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => {
        if (!response.ok) throw new Error('Erreur réseau : ' + response.status);
        return response.text();
    })
    .then(html => {
        sectionAjax.innerHTML = html;

        // ✅ On remet tout à la normale une fois le contenu chargé
        sectionAjax.style.opacity       = '1';
        sectionAjax.style.pointerEvents = 'auto';

        if ($.fn.DataTable) {
            if ($('#dataTableStudents').length) {
                $('#dataTableStudents').DataTable();
            }
            if ($('#dataTableTeachers').length) {
                $('#dataTableTeachers').DataTable();
            }
            if ($('#dataTable').length) {
                $('#dataTable').DataTable();
            }
            if ($('#dataTableFormations').length) {
                $('#dataTableFormations').DataTable();
            }
        }
    })
    .catch(error => {
        sectionAjax.innerHTML           = `<div class="alert alert-danger">Impossible de charger la section. (${error.message})</div>`;
        sectionAjax.style.opacity       = '1';
        sectionAjax.style.pointerEvents = 'auto';
    });
}

sidebarLinks.forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        loadSection(this.dataset.section, this);
    });
});

const profilLink = document.querySelector('[data-section="profil"]');
if (profilLink) {
    profilLink.style.backgroundColor = '#e8630a';
    profilLink.style.color = '#fff';
}

/**
 * Affiche un toast Bootstrap en bas à droite.
 *
 * @param {string}   message  - Le texte à afficher dans le toast
 * @param {string}   type     - 'success' (vert) ou 'danger' (rouge)
 * @param {function} callback - (optionnel) Fonction exécutée 300ms après l'affichage
 *                              → Utilisé pour recharger la section APRÈS que le toast soit visible
 */
function showToast(message, type = 'success', callback = null) {
    // On cherche le conteneur FIXE qui est dans le body principal (jamais écrasé par loadSection)
    const container = document.getElementById('toast-container-fixed');

    if (!container) {
        console.warn('showToast : #toast-container-fixed introuvable dans le DOM.');
        if (callback) callback();
        return;
    }

    const bg = type === 'success' ? 'text-bg-success' : 'text-bg-danger';

    const toastEl = document.createElement('div');
    toastEl.className = `toast align-items-center ${bg} border-0`;
    toastEl.setAttribute('role', 'alert');
    toastEl.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"></button>
        </div>`;

    container.appendChild(toastEl);

    const bsToast = new bootstrap.Toast(toastEl, { delay: 3000 });
    bsToast.show();

    toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());

    // On attend 300ms que le toast soit bien visible AVANT de recharger la section
    if (callback) {
        setTimeout(callback, 300);
    }
}