<?= $this->include('includes/header') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <h2 class="mb-4 text-center fw-bold">Mot de passe oublie</h2>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <p class="text-muted small mb-4">
                        Entrez l'email de votre compte et choisissez un nouveau mot de passe.
                    </p>

                    <form action="<?= base_url('/forgot-password') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                   class="form-control"
                                   id="email"
                                   name="email"
                                   value="<?= old('email') ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="mdp" class="form-label">Nouveau mot de passe</label>
                            <input type="password"
                                   class="form-control"
                                   id="mdp"
                                   name="mdp"
                                   required>
                            <div class="form-text">8 caracteres minimum.</div>
                        </div>

                        <div class="mb-4">
                            <label for="mdp_confirm" class="form-label">Confirmer le mot de passe</label>
                            <input type="password"
                                   class="form-control"
                                   id="mdp_confirm"
                                   name="mdp_confirm"
                                   required>
                        </div>

                        <button type="submit" class="btn w-100 text-white" style="background-color: #e8630a;">
                            Réinitialiser mon mot de passe
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="<?= base_url('/login') ?>">Retour a la connexion</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->include('includes/footer') ?>
