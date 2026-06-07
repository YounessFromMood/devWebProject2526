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

<div class="modal fade" id="modalCreateTeacher" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un formateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="createTeacherError" class="alert alert-danger d-none"></div>
                <div class="mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" id="createPrenom" class="form-control" placeholder="Prénom">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" id="createNom" class="form-control" placeholder="Nom">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" id="createEmail" class="form-control" placeholder="email@exemple.be">
                </div>
                <div class="mb-3">
                    <label class="form-label">Téléphone <span class="text-muted">(optionnel)</span></label>
                    <input type="text" id="createTel" class="form-control" placeholder="+32 470 00 00 00">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" id="createMdp" class="form-control" placeholder="Mot de passe">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn text-white" style="background-color: #e8630a;"
                        id="btnConfirmCreate">Créer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditTeacher" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le formateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="editTeacherError" class="alert alert-danger d-none"></div>
                <input type="hidden" id="editId">
                <div class="mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" id="editPrenom" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" id="editNom" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" id="editEmail" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Téléphone <span class="text-muted">(optionnel)</span></label>
                    <input type="text" id="editTel" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nouveau mot de passe <span class="text-muted">(laisser vide pour ne pas changer)</span></label>
                    <input type="password" id="editMdp" class="form-control" placeholder="••••••••">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn text-white" style="background-color: #e8630a;"
                        id="btnConfirmEdit">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteTeacher" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer <strong id="deleteTeacherName"></strong> ?</p>
                <input type="hidden" id="deleteId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDelete">Supprimer</button>
            </div>
        </div>
    </div>
</div>


<script src="<?= base_url('js/admin/teacher.js') ?>"></script>