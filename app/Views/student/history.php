<h2 class="fw-bold mb-4">Historique des formations suivies</h2>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">

        <?php if (empty($sessions)): ?>
            <p class="text-muted text-center">Aucune formation terminée pour le moment.</p>
        <?php else: ?>
        <table id="dataTableHistory" class="table table-hover w-100">
            <thead>
                <tr>
                    <th>Formation</th>
                    <th>Formateur</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Modalité</th>
                    <th class="dt-type-numeric">Prix</th>
                    <th>Résultat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sessions as $s): ?>
                <tr>
                    <td class="fw-semibold"><?= esc($s['formation_titre']) ?></td>
                    <td><?= esc($s['formateur_nom']) ?></td>
                    <td><?= esc(date('d/m/Y', strtotime($s['date_debut']))) ?></td>
                    <td><?= esc(date('d/m/Y', strtotime($s['date_fin']))) ?></td>
                    <td><?= esc($s['modalite_libelle']) ?></td>
                    <td><?= $s['prix'] ? esc($s['prix']) . ' €' : '—' ?></td>
                    <td>
                        <?php if (!empty($s['note_libelle'])): ?>
                            <?php if ($s['note_libelle'] === 'Réussite'): ?>
                                <span class="badge bg-success">Réussite</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">A participé</span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-muted fst-italic">En attente</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

    </div>
</div>