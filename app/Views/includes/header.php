<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?= isset($pageTitle) ? esc($pageTitle) . ' - En Formation!' : 'En Formation!' ?></title>
        <!-- jQuery -->
        <script src="<?= base_url('js/jquery.min.js') ?>"></script>
        <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>">
        <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?= base_url('css/style.css') ?>">
        <link rel="stylesheet" href="<?= base_url('css/dataTables.min.css') ?>">
    </head>
    <body body class="d-flex flex-column min-vh-100">
        <header>
            <nav id="top" class="navbar navbar-expand-lg px-3" style="background-color: #e8630a;">
                <div class="container-fluid">

                    <a class="navbar-brand fw-bold text-white" href="<?= base_url('/') ?>">
                        En Formation!
                    </a>

                    <button class="navbar-toggler border-white" data-bs-toggle="collapse" data-bs-target="#mainNav">
                        <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="mainNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="<?= base_url('/') ?>">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="<?= base_url('/formations') ?>">Formations</a>
                            </li>
                        </ul>

                        <ul class="navbar-nav ms-auto">
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
                    </div>

                </div>
            </nav>

        </header>
        <main class="flex-grow-1">