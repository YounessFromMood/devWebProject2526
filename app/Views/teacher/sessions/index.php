<h2 class="fw-bold mb-4">Mes sessions</h2>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">

        <?php if (empty($sessions)): ?>
            <p class="text-muted text-center">Aucune session assignée pour le moment.</p>
        <?php else: ?>
        <table id="dataTableSessions" class="table table-hover w-100">
            <thead>
                <tr>
                    <th>Formation</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Modalité</th>
                    <th>Lieu / Lien</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sessions as $s): ?>
                <tr>
                    <td><?= esc($s['formation_titre']) ?></td>
                    <td><?= esc($s['date_debut']) ?></td>
                    <td><?= esc($s['date_fin']) ?></td>
                    <td><?= esc($s['modalite_libelle']) ?></td>
                    <td><?= esc($s['lieu_session'] ?? '—') ?></td>
                    <td><?= $s['prix'] ? esc($s['prix']) . ' €' : '—' ?></td>
                    <td class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-secondary btn-view-students"
                                data-id-session="<?= $s['id_session'] ?>"
                                data-titre="<?= esc($s['formation_titre']) ?> — <?= esc($s['date_debut']) ?>">
                            Étudiants
                        </button>
                        <button class="btn btn-sm btn-outline-secondary btn-manage-link"
                                data-id-session="<?= $s['id_session'] ?>"
                                data-titre="<?= esc($s['formation_titre']) ?> — <?= esc($s['date_debut']) ?>"
                                data-lieu="<?= esc($s['lieu_session'] ?? '') ?>">
                            Lieu / Lien
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

    </div>
</div>