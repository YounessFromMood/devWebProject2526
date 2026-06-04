<?= $this->include('includes/header') ?>

<div class="d-flex" style="min-height: calc(100vh - 56px);">

    <!-- ===================== SIDEBAR ===================== -->
    <nav id="adminSidebar" class="d-flex flex-column p-3 text-white" 
         style="width: 240px; min-width: 240px; background-color: #1e1e2e;">

        <!-- Titre sidebar -->
        <div class="mb-4 mt-2">
            <span class="fw-bold fs-5" style="color: #e8630a;">&#9679; Administration</span>
        </div>

        <!-- Menu de navigation -->
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

        <!-- Bouton déconnexion en bas -->
        <div class="mt-auto">
            <a href="<?= base_url('/logout') ?>" 
               class="btn btn-sm w-100 text-white"
               style="background-color: #e8630a;">
                Déconnexion
            </a>
        </div>

    </nav>

    <main class="flex-grow-1 p-4 bg-light">
    <!-- ===================== SIDEBAR ===================== -->

        <!-- Zone de chargement AJAX — par défaut : profil user -->
        <div id="mainContent">

            <!-- ---- SECTION PROFIL ---- -->
            <div id="section-profil">

                <h2 class="fw-bold mb-4">Mon profil</h2>

                <div class="card shadow-sm border-0" style="max-width: 500px;">
                    <div class="card-body p-4">

                        <div class="d-flex align-items-center mb-4 gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold fs-4"
                                 style="width: 64px; height: 64px; background-color: #e8630a;">
                                <?= strtoupper(substr(session('prenom'), 0, 1) . substr(session('nom'), 0, 1)) ?>
                            </div>
                            <div>
                                <div class="fw-bold fs-5"><?= esc(session('prenom')) ?> <?= esc(session('nom')) ?></div>
                                <span class="badge text-white" style="background-color: #e8630a;">Administrateur</span>
                            </div>
                        </div>

                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width: 120px;">Prénom</td>
                                    <td class="fw-semibold"><?= esc(session('prenom')) ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Nom</td>
                                    <td class="fw-semibold"><?= esc(session('nom')) ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Email</td>
                                    <td class="fw-semibold"><?= esc(session('email')) ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Rôle</td>
                                    <td class="fw-semibold">Administrateur</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
            <!-- ---- FIN SECTION PROFIL ---- -->

            <div id="section-ajax" style="display: none;"></div>

        </div>

    </main>

</div>

<?= $this->include('includes/footer') ?>
<script>
    const BASE_URL = "<?= base_url() ?>";
</script>
<script src="<?= base_url('js/dashboard/admin_dashboard.js') ?>"></script>