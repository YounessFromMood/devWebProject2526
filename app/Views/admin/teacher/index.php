<h2 class="fw-bold mb-4">Gestion des formateurs</h2>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">

        <div class="mb-3 text-end">
            <button class="btn btn-sm text-white" style="background-color: #e8630a;"
                    data-bs-toggle="modal" data-bs-target="#modalCreateTeacher">
                + Ajouter un formateur
            </button>
        </div>

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
                <?php foreach ($teachers as $teacher): ?>
                <tr>
                    <td><?= esc($teacher['prenom']) ?></td>
                    <td><?= esc($teacher['nom']) ?></td>
                    <td><?= esc($teacher['email']) ?></td>
                    <td><?= esc($teacher['num_tel'] ?? '—') ?></td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary btn-edit-teacher"
                                data-id="<?= $teacher['id_formateur'] ?>"
                                data-prenom="<?= esc($teacher['prenom']) ?>"
                                data-nom="<?= esc($teacher['nom']) ?>"
                                data-email="<?= esc($teacher['email']) ?>"
                                data-tel="<?= esc($teacher['num_tel'] ?? '') ?>">
                            Modifier
                        </button>
                        <button class="btn btn-sm btn-outline-danger btn-delete-teacher"
                                data-id="<?= $teacher['id_formateur'] ?>"
                                data-nom="<?= esc($teacher['prenom']) ?> <?= esc($teacher['nom']) ?>">
                            Supprimer
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>