<?= $this->include('includes/header') ?>

<div id="toast-container-fixed" class="toast-container position-fixed bottom-0 end-0 p-3"></div>

<div class="d-flex" style="min-height: calc(100vh - 56px);">

    <nav id="adminSidebar" class="d-flex flex-column p-3 text-white"
         style="width: 240px; min-width: 240px; background-color: #1e1e2e;">

        <div class="mb-4 mt-2">
            <span class="fw-bold fs-5" style="color: #e8630a;">&#9679; Administration</span>
        </div>

        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="#" class="nav-link sidebar-link active" data-section="profil"
                   style="color: #ccc; border-radius: 6px;">
                    Mon profil
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link sidebar-link" data-section="etudiants"
                   style="color: #ccc; border-radius: 6px;">
                    Gestion des élèves
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link sidebar-link" data-section="formateurs"
                   style="color: #ccc; border-radius: 6px;">
                    Gestion des formateurs
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link sidebar-link" data-section="formations"
                   style="color: #ccc; border-radius: 6px;">
                    Gestion des formations
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link sidebar-link" data-section="paiements"
                   style="color: #ccc; border-radius: 6px;">
                    Gestion des paiements
                </a>
            </li>
        </ul>

        <div class="mt-auto">
            <a href="<?= base_url('/logout') ?>"
               class="btn btn-sm w-100 text-white"
               style="background-color: #e8630a;">
                Déconnexion
            </a>
        </div>

    </nav>

    <main class="flex-grow-1 p-4 bg-light">

        <div id="mainContent">

            <?= $this->include('includes/profile_section') ?>
            <div id="section-ajax" style="display: none;"></div>

        </div>

    </main>

</div>

<?php if (session()->getFlashdata('success')): ?>
    <div id="flash-success" 
         data-message="<?= esc(session()->getFlashdata('success')) ?>" 
         style="display:none;">
    </div>
<?php endif; ?>

<?= $this->include('admin/teacher/modals') ?>
<?= $this->include('admin/student/modals') ?>
<?= $this->include('admin/formation/modals') ?>
<?= $this->include('admin/session/modals') ?> 

<script src="<?= base_url('js/datatables.min.js') ?>"></script>
<script>
    const BASE_URL = "<?= base_url() ?>";
    const TYPES_FORMATION = <?= json_encode($types_formation) ?>;
</script>
<script src="<?= base_url('js/profile.js') ?>"></script>
<script src="<?= base_url('js/dashboard/admin_dashboard.js') ?>"></script>
<script src="<?= base_url('js/admin/student.js') ?>"></script>
<script src="<?= base_url('js/admin/teacher.js') ?>"></script>
<script src="<?= base_url('js/admin/formation.js') ?>"></script>
<script src="<?= base_url('js/admin/session.js') ?>"></script>
<script src="<?= base_url('js/admin/payment.js') ?>"></script>