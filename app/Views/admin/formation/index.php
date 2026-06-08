<h2 class="fw-bold mb-4">Gestion des formations</h2>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">

        <div class="mb-3 text-end d-flex justify-content-end gap-2">
            <button class="btn btn-sm btn-outline-secondary" id="btnShowDeletedFormations">
                Formations supprimées
            </button>
            <button class="btn btn-sm text-white" style="background-color: #e8630a;"
                    data-bs-toggle="modal" data-bs-target="#modalCreateFormation">
                + Ajouter une formation
            </button>
        </div>

        <table id="dataTableFormations" class="table table-hover w-100">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Type(s)</th>
                    <th>Durée</th>
                    <th>Prix</th>
                    <th>Langue</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($formations as $formation): ?>
                <tr>
                    <td><?= esc($formation['titre']) ?></td>
                    <td><?= esc($formation['types'] ?? 'À déterminer') ?></td>
                    <td><?= esc($formation['duree'] ?? 'À déterminer') ?></td>
                    <td><?= $formation['prix'] ? esc($formation['prix']) . ' €' : '—' ?></td>
                    <td><?= esc($formation['langue'] ?? 'À déterminer') ?></td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary btn-edit-formation"
                                data-id="<?= $formation['id_formation'] ?>"
                                data-titre="<?= esc($formation['titre']) ?>"
                                data-description="<?= esc($formation['DESCRIPTION']) ?>"
                                data-duree="<?= esc($formation['duree'] ?? '') ?>"
                                data-prix="<?= esc($formation['prix'] ?? '') ?>"
                                data-langue="<?= esc($formation['langue'] ?? '') ?>">
                            Modifier
                        </button>
                        <button class="btn btn-sm btn-outline-danger btn-delete-formation"
                                data-id="<?= $formation['id_formation'] ?>"
                                data-titre="<?= esc($formation['titre']) ?>">
                            Supprimer
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <script>
            const TYPES_FORMATION = <?= json_encode($types) ?>;
        </script>

    </div>
</div>