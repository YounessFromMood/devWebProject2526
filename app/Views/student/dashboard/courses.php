<h2 class="fw-bold mb-4">Mes sessions</h2>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">

        <?php if (empty($sessions)): ?>
            <p class="text-muted text-center">Vous n'êtes inscrit à aucune session en cours pour le moment.</p>
        <?php else: ?>
        <table id="dataTableSessions" class="table table-hover w-100">
            <thead>
                <tr>
                    <th>Formation</th>
                    <th>Formateur</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Modalité</th>
                    <th>Lieu / Lien</th>
                    <th class="dt-type-numeric">Prix</th>
                    <th>Statut</th>
                    <th>Facture</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sessions as $s):
                    $today     = date('Y-m-d');
                    $isOngoing = $s['date_debut'] <= $today;
                    $isPaid    = (bool) $s['paiement_recu'];
                ?>
                <tr>
                    <td class="fw-semibold"><?= esc($s['formation_titre']) ?></td>
                    <td><?= esc($s['formateur_nom']) ?></td>
                    <td><?= esc(date('d/m/Y', strtotime($s['date_debut']))) ?></td>
                    <td><?= esc(date('d/m/Y', strtotime($s['date_fin']))) ?></td>
                    <td><?= esc($s['modalite_libelle']) ?></td>
                    <td>
                        <?php if (!empty($s['lieu_session'])): ?>
                            <?php if (filter_var($s['lieu_session'], FILTER_VALIDATE_URL)): ?>
                                <a href="<?= esc($s['lieu_session']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    Rejoindre
                                </a>
                            <?php else: ?>
                                <?= esc($s['lieu_session']) ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $s['prix'] ? esc($s['prix']) . ' €' : '—' ?></td>
                    <td>
                        <?php if ($isOngoing): ?>
                            <span class="badge text-white" style="background-color: #e8630a;">En cours</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">À venir</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($isPaid): ?>
                            <span class="badge bg-success">Payée</span>
                        <?php else: ?>
                            <a href="<?= base_url('student/payment/' . $s['id_session']) ?>"
                               class="badge text-decoration-none"
                               style="background-color: #e8630a; color: white;">
                                Non payée
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

    </div>
</div>