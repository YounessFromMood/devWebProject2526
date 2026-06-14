<?= $this->include('includes/header') ?>

<section class="py-5 text-white" style="background-color: #e8630a;">
    <div class="container">
        <a href="javascript:history.back()" class="text-white text-decoration-none d-inline-flex align-items-center gap-2 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
            </svg>
            Retour
        </a>
        <h1 class="display-5 fw-bold mb-1">Confirmer l'inscription</h1>
        <p class="lead mb-0"><?= esc($session['formation_titre']) ?></p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger mb-4">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4" style="color: #e8630a;">Récapitulatif de la session</h5>

                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width: 140px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1 mb-1" viewBox="0 0 16 16">
                                            <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                                            <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                        </svg>
                                        Dates
                                    </td>
                                    <td class="fw-semibold">
                                        Du <?= date('d/m/Y', strtotime($session['date_debut'])) ?>
                                        au <?= date('d/m/Y', strtotime($session['date_fin'])) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1 mb-1" viewBox="0 0 16 16">
                                            <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                                            <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.4 5.4 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z"/>
                                        </svg>
                                        Formateur
                                    </td>
                                    <td class="fw-semibold"><?= esc($session['formateur_prenom'] . ' ' . $session['formateur_nom']) ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Modalité</td>
                                    <td class="fw-semibold"><?= esc($session['modalite_libelle']) ?></td>
                                </tr>
                                <?php if (!empty($session['lieu_session'])) : ?>
                                    <tr>
                                        <td class="text-muted">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1 mb-1" viewBox="0 0 16 16">
                                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
                                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                            </svg>
                                            Lieu
                                        </td>
                                        <td class="fw-semibold"><?= esc($session['lieu_session']) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (!empty($session['prix'])) : ?>
                                    <tr>
                                        <td class="text-muted">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1 mb-1" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                                <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                                                <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                                            </svg>
                                            Prix
                                        </td>
                                        <td class="fw-semibold"><?= number_format($session['prix'], 2, ',', ' ') ?> €</td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="text-muted">Places restantes</td>
                                    <td class="fw-semibold"><?= max(0, $session['places_restantes']) ?> / <?= esc($session['nb_etudiant_max']) ?></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <form action="<?= base_url('/session/registration/' . $session['id_session']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-lg text-white fw-bold" style="background-color: #e8630a;">
                            Confirmer mon inscription
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<?= $this->include('includes/footer') ?>