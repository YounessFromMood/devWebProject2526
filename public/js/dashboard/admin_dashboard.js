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
    sectionAjax.innerHTML       = '<p class="text-muted">Chargement...</p>';

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
        sectionAjax.innerHTML = `<div class="alert alert-danger">Impossible de charger la section. (${error.message})</div>`;
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

function showToast(message, type = 'success') {
    const container = document.querySelector('.toast-container');
    const bg = type === 'success' ? 'text-bg-success' : 'text-bg-danger';

    const toastEl = document.createElement('div');
    toastEl.className = `toast align-items-center ${bg} border-0 show`;
    toastEl.setAttribute('role', 'alert');
    toastEl.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"></button>
        </div>`;

    container.appendChild(toastEl);
    new bootstrap.Toast(toastEl, { delay: 3000 }).show();
    toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
}