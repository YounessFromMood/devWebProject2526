<h2 class="fw-bold mb-4">Mes notes</h2>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">

        <?php if (empty($grades)): ?>
            <p class="text-muted text-center">Aucune note attribuée pour le moment.</p>
        <?php else: ?>
        <table id="dataTableGrades" class="table table-hover w-100">
            <thead>
                <tr>
                    <th>Formation</th>
                    <th>Résultat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grades as $g): ?>
                <tr>
                    <td class="fw-semibold"><?= esc($g['session_titre']) ?></td>
                    <td>
                        <?php if ($g['note_libelle'] === 'Réussite'): ?>
                            <span class="badge bg-success">Réussite</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">A participé</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

    </div>
</div>