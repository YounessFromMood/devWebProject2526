<?php
$roleLabels = [
    'eleve'     => 'Etudiant',
    'formateur' => 'Formateur',
    'admin'     => 'Administrateur',
];
$roleLabel = $roleLabels[session('role')] ?? 'Utilisateur';
$photo     = session('photo_profil');
?>
<div id="section-profil">

    <h2 class="fw-bold mb-4">Mon profil</h2>

    <div class="row g-4" style="max-width: 800px;">

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4 text-center">

                    <div id="apercu-initiales"
                         class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold fs-2 mx-auto mb-3 <?= !empty($photo) ? 'd-none' : '' ?>"
                         style="width:120px;height:120px;background-color:#e8630a;">
                        <?= strtoupper(substr(session('prenom'), 0, 1) . substr(session('nom'), 0, 1)) ?>
                    </div>

                    <img id="apercu-photo"
                         src="<?= !empty($photo) ? base_url($photo) : '' ?>"
                         alt="Photo de profil"
                         class="rounded-circle mb-3 <?= empty($photo) ? 'd-none' : '' ?>"
                         style="width:120px;height:120px;object-fit:cover;">

                    <form id="form-photo" enctype="multipart/form-data">
                        <input type="hidden" class="csrf-token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                        <div class="mb-2">
                            <input type="file" class="form-control form-control-sm"
                                   name="photo_profil" accept="image/png, image/jpeg, image/webp">
                            <div class="form-text">Formats acceptes : JPG, PNG ou WEBP &mdash; 2 Mo maximum.</div>
                        </div>
                        <button type="submit" class="btn btn-sm w-100 text-white" style="background-color:#e8630a;">
                            Changer la photo
                        </button>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fw-bold fs-5">
                            <span id="profil-prenom"><?= esc(session('prenom')) ?></span>
                            <span id="profil-nom"><?= esc(session('nom')) ?></span>
                        </span>
                        <span class="badge text-white" style="background-color:#e8630a;"><?= $roleLabel ?></span>
                    </div>

                    <form id="form-infos">
                        <input type="hidden" class="csrf-token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prenom</label>
                                <input type="text" class="form-control" name="prenom"
                                       value="<?= esc(session('prenom')) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" class="form-control" name="nom"
                                       value="<?= esc(session('nom')) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                   value="<?= esc(session('email')) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" name="mdp"
                                   placeholder="Laisser vide pour ne pas changer">
                            <div class="form-text">8 caracteres minimum. Vide = inchange.</div>
                        </div>

                        <button type="submit" class="btn text-white" style="background-color:#e8630a;">
                            Enregistrer
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>

</div>