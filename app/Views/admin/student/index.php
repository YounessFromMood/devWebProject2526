<h2 class="fw-bold mb-4">Gestion des étudiants</h2>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">

        <div class="mb-3 text-end d-flex justify-content-end gap-2">
        <button class="btn btn-sm btn-outline-secondary" id="btnShowDeleted">
            Étudiants supprimés
        </button>
        <button class="btn btn-sm text-white" style="background-color: #e8630a;"
                data-bs-toggle="modal" data-bs-target="#modalCreateStudent">
            + Ajouter un étudiant
        </button>
    </div>

        <table id="dataTableStudents" class="table table-hover w-100">
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
                        <button class="btn btn-sm btn-outline-secondary btn-edit-student"
                                data-id="<?= $student['id_eleve'] ?>"
                                data-prenom="<?= esc($student['prenom']) ?>"
                                data-nom="<?= esc($student['nom']) ?>"
                                data-email="<?= esc($student['email']) ?>"
                                data-tel="<?= esc($student['num_tel'] ?? '') ?>">
                            Modifier
                        </button>
                        <button class="btn btn-sm btn-outline-danger btn-delete-student"
                                data-id="<?= $student['id_eleve'] ?>"
                                data-nom="<?= esc($student['prenom']) ?> <?= esc($student['nom']) ?>">
                            Supprimer
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>