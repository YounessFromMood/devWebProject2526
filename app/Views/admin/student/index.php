<h2 class="fw-bold mb-4">Gestion des élèves</h2>
 
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
 
        <table id="dataTable" class="table table-hover w-100">
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= esc($student['prenom']) ?></td>
                    <td><?= esc($student['nom']) ?></td>
                    <td><?= esc($student['email']) ?></td>
                    <td><?= esc($student['num_tel'] ?? '—') ?></td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary">Modifier</button>
                        <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
 
    </div>
</div>