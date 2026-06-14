<?= $this->include('includes/header') ?>

<section class="py-5 text-white" style="background-color: #e8630a;">
    <div class="container">
        <h1 class="display-5 fw-bold mb-1">Paiement</h1>
        <p class="lead mb-0"><?= esc($session['formation_titre']) ?></p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger mb-4"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4" style="color: #e8630a;">Détails de votre inscription</h5>

                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width: 160px;">Formation</td>
                                    <td class="fw-semibold"><?= esc($session['formation_titre']) ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Dates</td>
                                    <td class="fw-semibold">
                                        Du <?= date('d/m/Y', strtotime($session['date_debut'])) ?>
                                        au <?= date('d/m/Y', strtotime($session['date_fin'])) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Formateur</td>
                                    <td class="fw-semibold"><?= esc($session['formateur_prenom'] . ' ' . $session['formateur_nom']) ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Modalité</td>
                                    <td class="fw-semibold"><?= esc($session['modalite_libelle']) ?></td>
                                </tr>
                                <?php if (!empty($session['lieu_session'])) : ?>
                                    <tr>
                                        <td class="text-muted">Lieu</td>
                                        <td class="fw-semibold"><?= esc($session['lieu_session']) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="text-muted">Montant dû</td>
                                    <td class="fw-bold fs-5" style="color: #e8630a;">
                                        <?= number_format($session['prix'], 2, ',', ' ') ?> €
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-left: 4px solid #e8630a !important;">
                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4" style="color: #e8630a;">Coordonnées bancaires</h5>

                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width: 160px;">Bénéficiaire</td>
                                    <td class="fw-semibold">En Formation! ASBL</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">IBAN</td>
                                    <td class="fw-semibold">BE68 5390 0754 7034</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">BIC</td>
                                    <td class="fw-semibold">TRIOBEBB</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Montant</td>
                                    <td class="fw-semibold"><?= number_format($session['prix'], 2, ',', ' ') ?> €</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Communication</td>
                                    <td>
                                        <span class="fw-bold font-monospace fs-5" style="color: #e8630a;">
                                            <?= esc($communication) ?>
                                        </span>
                                        <div class="text-muted small mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;">
                                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                                <line x1="12" y1="9" x2="12" y2="13"/>
                                                <line x1="12" y1="17" x2="12.01" y2="17"/>
                                            </svg>
                                            Merci de mentionner cette communication lors de votre virement.
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="alert alert-warning mb-4">
                    <strong>Important :</strong> Une fois votre virement effectué, cliquez sur le bouton ci-dessous pour en informer l'administration. Votre inscription sera officiellement confirmée après vérification du paiement.
                </div>

                <form action="<?= base_url('/student/payment/' . $session['id_session']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-lg text-white fw-bold" style="background-color: #e8630a;">
                            J'ai effectué mon virement
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<?= $this->include('includes/footer') ?>