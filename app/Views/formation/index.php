<?= $this->include('includes/header') ?>

<section class="py-5 text-white text-center" style="background-color: #e8630a;">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">Rechercher une formation</h1>
        <p class="lead mb-0">Utilise les filtres ci-dessous pour trouver la formation qui te correspond.</p>
    </div>
</section>

<section class="py-4 bg-light border-bottom">
    <div class="container">
        <form id="formFiltres" class="row gy-3 align-items-end">

            <div class="col-md-5">
                <label for="filtreTitre" class="form-label fw-semibold">Mot-clé</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e8630a" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </span>
                    <input type="text" id="filtreTitre" class="form-control" placeholder="Ex: Java, cybersécurité...">
                </div>
            </div>

            <div class="col-md-3">
                <label for="filtrePrixMax" class="form-label fw-semibold">Prix maximum (€)</label>
                <input type="number" id="filtrePrixMax" class="form-control" min="0" step="1" placeholder="Ex: 300">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold d-block">Domaines</label>
                <div class="d-flex flex-wrap gap-3">
                    <?php foreach ($types as $type) : ?>
                        <div class="form-check">
                            <input class="form-check-input filtre-type" type="checkbox"
                                   value="<?= esc($type['id_type_formation']) ?>"
                                   id="type<?= esc($type['id_type_formation']) ?>">
                            <label class="form-check-label" for="type<?= esc($type['id_type_formation']) ?>">
                                <?= esc($type['libelle']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-12 d-flex gap-2 justify-content-end">
                <button type="button" id="btnReset" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z"/>
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466"/>
                    </svg>
                    Réinitialiser
                </button>
                <button type="submit" class="btn text-white d-flex align-items-center gap-2" style="background-color: #e8630a;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                    </svg>
                    Rechercher
                </button>
            </div>

        </form>
    </div>
</section>

<section class="py-5">
    <div class="container">

        <div id="loadingFormations" class="text-center py-5 d-none">
            <div class="spinner-border" style="color: #e8630a;" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <p class="text-muted mt-2">Recherche des formations...</p>
        </div>

        <div id="aucunResultat" class="text-center py-5 d-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#adb5bd" viewBox="0 0 16 16">
                <path d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438zM3.809 3.563A1.5 1.5 0 0 1 4.981 3h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374z"/>
            </svg>
            <p class="text-muted mt-3 mb-0">Aucune formation ne correspond à ta recherche.</p>
        </div>

        <div id="resultatsFormations" class="row g-4"></div>

    </div>
</section>

<script>
$(function () {

    const conteneur   = $('#resultatsFormations');
    const chargement  = $('#loadingFormations');
    const aucunResult = $('#aucunResultat');

    function creerCarte(formation) {
        const badgesTypes = (formation.types || []).map(function (libelle) {
            return '<span class="badge me-1 mb-1" style="background-color: #e8630a;">' + libelle + '</span>';
        }).join('');

        const description = formation.description
            ? '<p class="text-muted small mb-3">' + formation.description.slice(0, 140) + (formation.description.length > 140 ? '...' : '') + '</p>'
            : '';

        const duree = formation.duree
            ? '<span class="text-muted small me-3">' +
              '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="mb-1" viewBox="0 0 16 16">' +
              '<path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>' +
              '<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>' +
              '</svg> ' + formation.duree + '</span>'
            : '';

        const prix = formation.prix
            ? '<span class="text-muted small">' +
              '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="mb-1" viewBox="0 0 16 16">' +
              '<path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>' +
              '<path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>' +
              '<path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>' +
              '<path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>' +
              '</svg> ' + Number(formation.prix).toLocaleString('fr-BE', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €</span>'
            : '';

        return $('<div class="col-md-4 col-sm-6"></div>').html(
            '<div class="card h-100 shadow-sm border-0">' +
                '<div class="card-body d-flex flex-column">' +
                    '<div class="mb-2">' + badgesTypes + '</div>' +
                    '<h5 class="card-title fw-bold">' + formation.titre + '</h5>' +
                    description +
                    '<div class="mb-3">' + duree + prix + '</div>' +
                    '<a href="<?= base_url('/formations') ?>/' + formation.id_formation + '" ' +
                       'class="btn mt-auto text-white" style="background-color: #e8630a;">Voir la formation</a>' +
                '</div>' +
            '</div>'
        );
    }

    function rechercherFormations() {
        const filtres = {
            titre: $('#filtreTitre').val(),
            prix_max: $('#filtrePrixMax').val(),
            types: $('.filtre-type:checked').map(function () {
                return $(this).val();
            }).get()
        };

        conteneur.empty();
        aucunResult.addClass('d-none');
        chargement.removeClass('d-none');

        $.getJSON('<?= base_url('/formations/search') ?>', filtres, function (formations) {
            chargement.addClass('d-none');

            if (formations.length === 0) {
                aucunResult.removeClass('d-none');
                return;
            }

            formations.forEach(function (formation) {
                conteneur.append(creerCarte(formation));
            });
        }).fail(function () {
            chargement.addClass('d-none');
            aucunResult.removeClass('d-none');
        });
    }

    $('#formFiltres').on('submit', function (e) {
        e.preventDefault();
        rechercherFormations();
    });

    $('#btnReset').on('click', function () {
        $('#filtreTitre').val('');
        $('#filtrePrixMax').val('');
        $('.filtre-type').prop('checked', false);
        rechercherFormations();
    });

    rechercherFormations();
});
</script>

<?= $this->include('includes/footer') ?>