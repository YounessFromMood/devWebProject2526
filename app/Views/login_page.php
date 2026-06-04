<?= $this->include('includes/header') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <h2 class="mb-4 text-center fw-bold">Connexion</h2>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/login') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="<?= old('email') ?>"
                                required>
                            <div class="invalid-feedback">
                                Format d'email invalide.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mdp" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control"
                                    id="mdp"
                                    name="mdp"
                                    required>
                                <button class="btn btn-outline-secondary"
                                    type="button"
                                    id="togglePassword">
                                    <i class="ti ti-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                            class="btn w-100 text-white fw-bold"
                            style="background-color: #e8630a;">
                            Se connecter
                        </button>

                    </form>

                    <p class="text-center mt-3 mb-0" style="font-size: 14px;">
                        Pas encore de compte ?
                        <a href="<?= base_url('/register') ?>" style="color: #e8630a;">S'inscrire</a>
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?= base_url('js/login.js') ?>"></script>

<?= $this->include('includes/footer') ?>