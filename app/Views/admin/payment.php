<h2 class="fw-bold mb-4">Gestion des paiements</h2>
 
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
 
        <?php if (empty($pendingPayments)): ?>
            <p class="text-muted text-center">Aucun paiement en attente de confirmation.</p>
        <?php else: ?>
        <table id="dataTablePayments" class="table table-hover w-100">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>Formation</th>
                    <th>Date début session</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendingPayments as $p): ?>
                <tr id="payment-row-<?= $p['id_eleve'] ?>-<?= $p['id_session'] ?>">
                    <td><?= esc($p['nom_eleve']) ?></td>
                    <td><?= esc($p['titre']) ?></td>
                    <td><?= esc($p['date_debut'] ?? '—') ?></td>
                    <td><?= $p['prix'] ? esc($p['prix']) . ' €' : '—' ?></td>
                    <td>
                        <button class="btn btn-sm btn-success btn-confirm-payment"
                                data-eleve="<?= $p['id_eleve'] ?>"
                                data-session="<?= $p['id_session'] ?>">
                            ✓ A payé
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
 
    </div>
</div>