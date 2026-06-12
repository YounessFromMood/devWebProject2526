<?= $this->include('includes/header') ?>

<section class="py-5 text-white" style="background-color: #e8630a;">
    <div class="container">

        <a href="<?= base_url('/formations') ?>" class="text-white text-decoration-none d-inline-flex align-items-center gap-2 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
            </svg>
            Retour aux formations
        </a>

        <div class="mb-2">
            <?php foreach ($types as $libelle) : ?>
                <span class="badge bg-light text-dark me-1"><?= esc($libelle) ?></span>
            <?php endforeach; ?>
        </div>

        <h1 class="display-5 fw-bold mb-3"><?= esc($formation['titre']) ?></h1>

        <div class="d-flex flex-wrap gap-4">
            <?php if (!empty($formation['duree'])) : ?>
                <span class="d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                    </svg>
                    <?= esc($formation['duree']) ?>
                </span>
            <?php endif; ?>

            <?php if (!empty($formation['prix'])) : ?>
                <span class="d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                    </svg>
                    <?= number_format($formation['prix'], 2, ',', ' ') ?> €
                </span>
            <?php endif; ?>

            <?php if (!empty($formation['langue'])) : ?>
                <span class="d-flex align-items-center gap-2"><?= esc($formation['langue']) ?></span>
            <?php endif; ?>
        </div>

    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-5">

            <div class="col-lg-7">
                <h2 class="fw-bold mb-3" style="color: #e8630a;">Description</h2>
                <?php if (!empty($formation['description'])) : ?>
                    <p style="white-space: pre-line;"><?= esc($formation['description']) ?></p>
                <?php else : ?>
                    <p class="text-muted">Aucune description n'a été fournie pour cette formation.</p>
                <?php endif; ?>
            </div>

            <div class="col-lg-5">
                <h2 class="fw-bold mb-3" style="color: #e8630a;">Sessions disponibles</h2>

                <?php if (empty($sessions)) : ?>
                    <p class="text-muted">Aucune session à venir n'est actuellement programmée pour cette formation.</p>
                <?php else : ?>
                    <?php foreach ($sessions as $session) : ?>
                        <?php $estComplete = $session['places_restantes'] <= 0; ?>
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="fw-semibold d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e8630a" viewBox="0 0 16 16">
                                            <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                                            <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                        </svg>
                                        Du <?= date('d/m/Y', strtotime($session['date_debut'])) ?>
                                        au <?= date('d/m/Y', strtotime($session['date_fin'])) ?>
                                    </span>

                                    <?php if ($estComplete) : ?>
                                        <span class="badge bg-danger">Complet</span>
                                    <?php else : ?>
                                        <span class="badge" style="background-color: <?= esc($session['modalite_libelle']) === 'Distanciel' ? '#6c757d' : '#198754' ?>;">
                                            <?= esc($session['modalite_libelle']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex flex-column gap-1 text-muted small mb-3">
                                    <span class="d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                                            <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.4 5.4 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z"/>
                                        </svg>
                                        Formateur : <?= esc($session['formateur_prenom'] . ' ' . $session['formateur_nom']) ?>
                                    </span>

                                    <?php if (!empty($session['lieu_session'])) : ?>
                                        <span class="d-flex align-items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
                                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                            </svg>
                                            <?= esc($session['lieu_session']) ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if (!empty($session['nb_etudiant_max'])) : ?>
                                        <span class="d-flex align-items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                                            </svg>
                                            <?= max(0, $session['places_restantes']) ?> place<?= $session['places_restantes'] != 1 ? 's' : '' ?> restante<?= $session['places_restantes'] != 1 ? 's' : '' ?> sur <?= esc($session['nb_etudiant_max']) ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if (!empty($session['prix'])) : ?>
                                        <span class="d-flex align-items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                                <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                                                <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                                            </svg>
                                            <?= number_format($session['prix'], 2, ',', ' ') ?> €
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <?php if ($estComplete) : ?>
                                    <button type="button" class="btn btn-sm btn-secondary w-100" disabled>
                                        Inscription impossible
                                    </button>
                                <?php else : ?>
                                    <a href="<?= base_url('/session/registration/' . $session['id_session']) ?>"
                                       class="btn btn-sm text-white w-100" style="background-color: #e8630a;">
                                        S'inscrire à cette session
                                    </a>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<?= $this->include('includes/footer') ?>