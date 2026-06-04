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
                    <a class="nav-link text-white" href="<?= base_url('/formations') ?>">Formations</a>
                </li>
                <?php if (session()->has('user_id')) : ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= base_url('/dashboard') ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= base_url('/logout') ?>">Déconnexion</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= base_url('/login') ?>">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= base_url('/register') ?>">Inscription</a>
                    </li>
                <?php endif; ?>
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
<script src="<?= base_url('js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('js/dataTables.min.js') ?>"></script>
</body>
</html>