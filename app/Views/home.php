<?= $this->include('includes/header') ?>

<section class="py-5 text-white text-center" style="background-color: #e8630a;">
    <div class="container">
        <h1 class="display-4 fw-bold mb-2">En Formation!</h1>
        <p class="lead mb-0">La plateforme qui connecte les apprenants aux meilleures formations.</p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-4" style="color: #e8630a;">
            Formations à découvrir
        </h2>

        <?php if (!empty($formations)) : ?>
            <div id="carouselFormations" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">

                <div class="carousel-indicators">
                    <?php foreach ($formations as $index => $formation) : ?>
                        <button type="button"
                                data-bs-target="#carouselFormations"
                                data-bs-slide-to="<?= $index ?>"
                                class="<?= $index === 0 ? 'active' : '' ?>"
                                aria-label="Formation <?= $index + 1 ?>">
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="carousel-inner rounded shadow">
                    <?php foreach ($formations as $index => $formation) : ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <div class="d-flex align-items-center justify-content-center text-white p-5"
                                 style="background-color: #333; height: 400px; overflow: hidden;">
                                <div class="text-center px-4">
                                    <?php if (!empty($formation['type'])) : ?>
                                        <span class="badge mb-3 px-3 py-2" style="background-color: #e8630a; font-size: 0.85rem;">
                                            <?= esc($formation['type']) ?>
                                        </span>
                                    <?php endif; ?>

                                    <h3 class="fw-bold mb-3"><?= esc($formation['titre']) ?></h3>

                                    <?php if (!empty($formation['description'])) : ?>
                                        <p class="mb-3 text-white-50" style="max-width: 600px; margin: 0 auto;">
                                            <?= esc(mb_strimwidth($formation['description'], 0, 180, '...')) ?>
                                        </p>
                                    <?php endif; ?>

                                    <div class="d-flex justify-content-center gap-3 flex-wrap mb-4">
                                        <?php if (!empty($formation['duree'])) : ?>
                                            <span class="text-white-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                                                </svg>
                                                <?= esc($formation['duree']) ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if (!empty($formation['prix'])) : ?>
                                            <span class="text-white-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                                                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                                                </svg>
                                                <?= number_format($formation['prix'], 2, ',', ' ') ?> €
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <a href="<?= base_url('/formations/' . $formation['id_formation']) ?>"
                                       class="btn text-white px-4 py-2"
                                       style="background-color: #e8630a; border: none;">
                                        Voir la formation
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselFormations" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselFormations" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>

            </div>
        <?php else : ?>
            <p class="text-center text-muted">Aucune formation disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-md-7">
                <h2 class="fw-bold mb-4" style="color: #e8630a;">Qu'est-ce qu'En Formation ?</h2>
                <p class="mb-3">
                    <strong>En Formation</strong> est une plateforme dédiée à la montée en compétences.
                    Que tu sois débutant ou que tu cherches à approfondir un domaine précis, tu y trouveras
                    des formations adaptées à ton rythme et à tes objectifs.
                </p>
                <p class="mb-3">
                    Nos formations sont disponibles en <strong>présentiel</strong> ou en <strong>distanciel</strong>,
                    encadrées par des formateurs expérimentés et passionnés.
                </p>
                <p class="mb-0">
                    Sur <strong>En Formation</strong>, tu peux <strong>t'inscrire</strong> à une session, suivre ton
                    <strong>historique de formations</strong> et gérer ton parcours depuis ton espace personnel.
                </p>
            </div>

            <div class="col-md-5">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="card h-100 border-0 shadow-sm text-center p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#e8630a" class="mb-2" viewBox="0 0 16 16">
                                <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917z"/>
                                <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466z"/>
                            </svg>
                            <div class="fw-semibold">Formations variées</div>
                            <small class="text-muted">En ligne ou en présentiel</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card h-100 border-0 shadow-sm text-center p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#e8630a" class="mb-2" viewBox="0 0 16 16">
                                <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                                <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                            </svg>
                            <div class="fw-semibold">Sessions planifiées</div>
                            <small class="text-muted">Des dates claires et fixes</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card h-100 border-0 shadow-sm text-center p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#e8630a" class="mb-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
                            </svg>
                            <div class="fw-semibold">Suivi personnel</div>
                            <small class="text-muted">Ton historique accessible</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card h-100 border-0 shadow-sm text-center p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#e8630a" class="mb-2" viewBox="0 0 16 16">
                                <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                                <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.4 5.4 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z"/>
                            </svg>
                            <div class="fw-semibold">Formateurs qualifiés</div>
                            <small class="text-muted">Des experts à ton écoute</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="py-5 text-white text-center" style="background-color: #e8630a;">
    <div class="container">
        <h2 class="fw-bold mb-3">Tu te sens prêt à te lancer ?</h2>
        <p class="lead mb-4">Découvres les formations qui t'attendent !</p>
        <a href="<?= base_url('/formations') ?>"
           class="btn btn-light btn-lg fw-bold px-5 py-3"
           style="color: #e8630a; border-radius: 50px;">
            Explorer les formations →
        </a>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <h2 class="fw-bold text-center mb-2" style="color: #e8630a;">Une question ? Pose-la nous !</h2>
                <p class="text-center text-muted mb-4">On te répondra dans les plus brefs délais.</p>

                <form action="mailto:contact@enformation.be" method="post" enctype="text/plain" class="bg-white p-4 rounded shadow-sm">

                    <div class="mb-3">
                        <label for="contact_nom" class="form-label fw-semibold">Ton nom</label>
                        <input type="text"
                               id="contact_nom"
                               name="Nom"
                               class="form-control"
                               placeholder="Jean Dupont"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="contact_email" class="form-label fw-semibold">Ton adresse e-mail</label>
                        <input type="email"
                               id="contact_email"
                               name="Email"
                               class="form-control"
                               placeholder="jean.dupont@email.com"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="contact_sujet" class="form-label fw-semibold">Sujet</label>
                        <input type="text"
                               id="contact_sujet"
                               name="Sujet"
                               class="form-control"
                               placeholder="Ex: Question sur une session de formation"
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="contact_message" class="form-label fw-semibold">Ton message</label>
                        <textarea id="contact_message"
                                  name="Message"
                                  class="form-control"
                                  rows="5"
                                  placeholder="Écris ta question ici..."
                                  required></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit"
                                class="btn text-white px-5 py-2 fw-semibold"
                                style="background-color: #e8630a; border: none; border-radius: 50px;">
                            Envoyer
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>

<?= $this->include('includes/footer') ?>