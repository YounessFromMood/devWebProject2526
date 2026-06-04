/**
 * admin_dashboard.js
 * Gère la navigation latérale du dashboard admin via AJAX.
 */

const sectionProfil = document.getElementById('section-profil');
const sectionAjax   = document.getElementById('section-ajax');
const sidebarLinks  = document.querySelectorAll('.sidebar-link');

/**
 * Met à jour le lien actif dans la sidebar.
 * @param {HTMLElement} activeLink - le lien cliqué
 */
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

/**
 * Charge une section via AJAX et l'affiche dans la zone principale.
 * @param {string} section - le nom de la section (ex: 'etudiants')
 * @param {HTMLElement} link - le lien cliqué
 */
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
    sectionAjax.innerHTML       = '<p class="text-muted">Chargement...</p>';

    // Requête AJAX vers la route CodeIgniter correspondante
    const urls = {
        'etudiants'  : BASE_URL + 'admin/student/index',
        'formateurs' : BASE_URL + 'admin/teacher/index',
        'formations' : BASE_URL + 'admin/formation/index',
        'paiements'  : BASE_URL + 'admin/payment',
    };

    fetch(urls[section], {
        headers: {
            // On indique au serveur que c'est une requête AJAX
            // pour qu'il renvoie uniquement le fragment HTML, pas la page entière
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur réseau : ' + response.status);
        }
        return response.text();
    })
    .then(html => {
        sectionAjax.innerHTML = html;

        // Initialise DataTables si un tableau est présent dans la section chargée
        if ($.fn.DataTable && $('#dataTable').length) {
            $('#dataTable').DataTable();
        }
    })
    .catch(error => {
        sectionAjax.innerHTML = `
            <div class="alert alert-danger">
                Impossible de charger la section. (${error.message})
            </div>`;
    });
}

sidebarLinks.forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        const section = this.dataset.section;
        loadSection(section, this);
    });
});

const profilLink = document.querySelector('[data-section="profil"]');
if (profilLink) {
    profilLink.style.backgroundColor = '#e8630a';
    profilLink.style.color = '#fff';
}