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
                        <input type="hidden" name="redirect" value="<?= esc($_GET['redirect'] ?? '') ?>">


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
                                    id="togglePassword"
                                    title="Afficher / masquer le mot de passe">
                                    <span id="eyeIcon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input"
                                type="checkbox"
                                name="remember_me"
                                id="remember_me">
                            <label class="form-check-label" for="remember_me">
                                Se souvenir de moi
                            </label>
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

<script src="<?= base_url('js/login_page.js') ?>"></script>

<?= $this->include('includes/footer') ?>