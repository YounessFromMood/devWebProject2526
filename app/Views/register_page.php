<?= $this->include('includes/header') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <h2 class="mb-4 text-center fw-bold">Inscription</h2>

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

                    <form id="registerForm" action="<?= base_url('/register') ?>" method="POST" novalidate>
                        <?= csrf_field() ?>

                        <!-- Prénom -->
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text"
                                class="form-control"
                                id="prenom"
                                name="prenom"
                                value="<?= old('prenom') ?>"
                                placeholder="Votre prénom">
                            <div class="invalid-feedback" id="prenom-error"></div>
                        </div>

                        <!-- Nom -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text"
                                class="form-control"
                                id="nom"
                                name="nom"
                                value="<?= old('nom') ?>"
                                placeholder="Votre nom">
                            <div class="invalid-feedback" id="nom-error"></div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="<?= old('email') ?>"
                                placeholder="exemple@mail.com">
                            <div class="invalid-feedback" id="email-error"></div>
                        </div>

                        <!-- Téléphone (optionnel) -->
                        <div class="mb-3">
                            <label for="num_tel" class="form-label">
                                Téléphone <span class="text-muted" style="font-size: 13px;">(optionnel)</span>
                            </label>
                            <input type="tel"
                                class="form-control"
                                id="num_tel"
                                name="num_tel"
                                value="<?= old('num_tel') ?>"
                                placeholder="+32 470 00 00 00">
                            <div class="invalid-feedback" id="num_tel-error"></div>
                        </div>

                        <!-- Mot de passe -->
                        <div class="mb-3">
                            <label for="mdp" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control"
                                    id="mdp"
                                    name="mdp"
                                    placeholder="Minimum 8 caractères">
                                <button class="btn btn-outline-secondary"
                                    type="button"
                                    id="togglePassword"
                                    title="Afficher / Masquer">
                                    <span id="eyeIcon">
                                        <!-- Œil ouvert (mot de passe masqué) -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                            <div class="invalid-feedback d-block" id="mdp-error"></div>
                        </div>

                        <!-- Confirmation mot de passe -->
                        <div class="mb-4">
                            <label for="mdp_confirm" class="form-label">Confirmer le mot de passe</label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control"
                                    id="mdp_confirm"
                                    name="mdp_confirm"
                                    placeholder="Répétez votre mot de passe">
                                <button class="btn btn-outline-secondary"
                                    type="button"
                                    id="togglePasswordConfirm"
                                    title="Afficher / Masquer">
                                    <span id="eyeIconConfirm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                            <div class="invalid-feedback d-block" id="mdp_confirm-error"></div>
                        </div>

                        <button type="submit"
                            class="btn w-100 text-white fw-bold"
                            style="background-color: #e8630a;">
                            Créer mon compte
                        </button>

                    </form>

                    <p class="text-center mt-3 mb-0" style="font-size: 14px;">
                        Déjà un compte ?
                        <a href="<?= base_url('/login') ?>" style="color: #e8630a;">Se connecter</a>
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?= base_url('js/register_page.js') ?>"></script>

<?= $this->include('includes/footer') ?>