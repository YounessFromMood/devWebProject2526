<div class="d-flex align-items-center gap-2 mb-4">
    <button class="btn btn-sm btn-outline-secondary" id="btnBackToFormations">
        ← Retour aux formations
    </button>
    <h2 class="fw-bold mb-0">Sessions de la formation</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">

        <div class="mb-3 text-end d-flex justify-content-end gap-2">
            <button class="btn btn-sm btn-outline-secondary" id="btnShowDeletedSessions"
                    data-formation="<?= $id_formation ?>">
                Sessions supprimées
            </button>
            <button class="btn btn-sm text-white" style="background-color: #e8630a;"
                    data-bs-toggle="modal" data-bs-target="#modalCreateSession">
                + Ajouter une session
            </button>
        </div>

        <table id="dataTableSessions" class="table table-hover w-100">
            <thead>
                <tr>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Formateur</th>
                    <th>Modalité</th>
                    <th>Max élèves</th>
                    <th>Lieu / Lien</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sessions)): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">Aucune session pour cette formation.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($sessions as $s): ?>
                <tr>
                    <td><?= esc($s['date_debut']) ?></td>
                    <td><?= esc($s['date_fin']) ?></td>
                    <td><?= esc($s['formateur_prenom'] . ' ' . $s['formateur_nom']) ?></td>
                    <td><?= esc($s['modalite_libelle']) ?></td>
                    <td><?= esc($s['nb_etudiant_max']) ?></td>
                    <td><?= esc($s['lieu_session'] ?? '—') ?></td>
                    <td><?= $s['prix'] ? esc($s['prix']) . ' €' : '—' ?></td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary btn-edit-session"
                                data-id="<?= $s['id_session'] ?>"
                                data-debut="<?= esc($s['date_debut']) ?>"
                                data-fin="<?= esc($s['date_fin']) ?>"
                                data-prix="<?= esc($s['prix'] ?? '') ?>"
                                data-lieu="<?= esc($s['lieu_session'] ?? '') ?>"
                                data-formateur="<?= $s['id_formateur'] ?>"
                                data-modalite="<?= $s['id_modalite'] ?>"
                                data-formation="<?= $id_formation ?>">
                            Modifier
                        </button>
                        <button class="btn btn-sm btn-outline-danger btn-delete-session"
                                data-id="<?= $s['id_session'] ?>"
                                data-debut="<?= esc($s['date_debut']) ?>"
                                data-formation="<?= $id_formation ?>">
                            Supprimer
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

<script>
    window.SESSION_FORMATEURS = <?= json_encode($formateurs) ?>;
    window.SESSION_MODALITES  = <?= json_encode($modalites) ?>;
    window.CURRENT_ID_FORMATION = <?= $id_formation ?>;
</script>