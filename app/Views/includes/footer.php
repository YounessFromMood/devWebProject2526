</main>
<footer style="background-color: #e8630a;" class="py-3">
    <div class="container-fluid px-3">
        <div class="d-flex justify-content-between align-items-center">

            <span class="fw-bold text-white">En Formation!</span>

            <ul class="navbar-nav d-flex flex-row gap-3">
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= base_url('/') ?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= base_url('/legal/conditions') ?>">Conditions d'utilisation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= base_url('/legal/confidentialite') ?>">Confidentialité</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <a href="#top" class="text-white" style="font-size: 13px; text-decoration: none;">
                    ↑ Haut de page
                </a>
                <span class="text-white" style="font-size: 13px;">
                    &copy; <?= date('Y') ?> En Formation!
                </span>
            </div>

        </div>
    </div>
</footer>
<?= $this->include('includes/flashalert') ?>
</body>
</html>