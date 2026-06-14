const sectionProfil = document.getElementById('section-profil');
const sectionAjax   = document.getElementById('section-ajax');
const sidebarLinks  = document.querySelectorAll('.sidebar-link');

// Au chargement de la page, vérifie si un flash success existe
document.addEventListener('DOMContentLoaded', function () {
    const flash = document.getElementById('flash-success');
    if (flash) {
        showToast(flash.dataset.message, 'success');
    }
});

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

    sectionProfil.style.display     = 'none';
    sectionAjax.style.display       = 'block';
    sectionAjax.style.opacity       = '0.4';
    sectionAjax.style.pointerEvents = 'none';

    const urls = {
        'sessions'   : BASE_URL + 'teacher/sessions/index',
        'historique' : BASE_URL + 'teacher/history',
        'planning'   : BASE_URL + 'teacher/planning',
    };

    fetch(urls[section], {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => {
        if (!response.ok) throw new Error('Erreur réseau : ' + response.status);
        return response.text();
    })
    .then(html => {
        sectionAjax.innerHTML       = html;
        sectionAjax.style.opacity       = '1';
        sectionAjax.style.pointerEvents = 'auto';

        if ($.fn.DataTable) {
            if ($('#dataTableSessions').length) {
                $('#dataTableSessions').DataTable();
            }
            if ($('#dataTableHistory').length) {
                $('#dataTableHistory').DataTable();
            }
        }

        if (section === 'planning') {
            const existing = document.getElementById('planningScript');
            if (existing) existing.remove();

            const script = document.createElement('script');
            script.id  = 'planningScript';
            //cache-buster
            script.src = BASE_URL + 'js/teacher/planning.js?v=' + ASSET_VERSION;

            document.body.appendChild(script);
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

function showToast(message, type = 'success', callback = null) {
    const container = document.getElementById('toast-container-fixed');

    if (!container) {
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

    if (callback) {
        setTimeout(callback, 300);
    }
}