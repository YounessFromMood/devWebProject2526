<h2 class="fw-bold mb-4">Mon planning</h2>

<div class="d-flex justify-content-between align-items-center mb-3">
    <button class="btn btn-sm btn-outline-secondary" id="btnPrevMonth">&#8592; Mois précédent</button>
    <h5 class="mb-0 fw-bold" id="calendarTitle"></h5>
    <button class="btn btn-sm btn-outline-secondary" id="btnNextMonth">Mois suivant &#8594;</button>
</div>

<div id="calendarGrid" data-sessions="<?= esc(json_encode($sessions), 'attr') ?>"></div>