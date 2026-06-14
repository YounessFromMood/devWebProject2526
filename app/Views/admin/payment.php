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
                        <?php if ($p['paiement_recu'] == 2): ?>
                            <span class="badge bg-success">Paiement Confirmé</span>
                        <?php elseif ($p['paiement_recu'] == 1): ?>
                            <span class="badge bg-warning text-dark me-2">Virement signalé</span>
                            <button class="btn btn-sm btn-confirm-payment text-white fw-bold"
                                    data-eleve="<?= $p['id_eleve'] ?>"
                                    data-session="<?= $p['id_session'] ?>"
                                    style="background-color: #e8630a; border: none; transition: background-color 0.2s ease;"
                                    onmouseover="this.style.backgroundColor='#c4510a'"
                                    onmouseout="this.style.backgroundColor='#e8630a'">
                                Confirmer le paiement
                            </button>
                        <?php else: ?>
                            <span class="badge bg-secondary">En attente de signalement</span>
                        <?php endif; ?>
                    </td>                
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
 
    </div>
</div>