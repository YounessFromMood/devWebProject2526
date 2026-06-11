<h2 class="fw-bold mb-4">Historique des formations données</h2>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">

        <?php if (empty($sessions)): ?>
            <p class="text-muted text-center">Aucune session terminée pour le moment.</p>
        <?php else: ?>
        <table id="dataTableHistory" class="table table-hover w-100">
            <thead>
                <tr>
                    <th>Formation</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Modalité</th>
                    <th>Lieu / Lien</th>
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
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

    </div>
</div>