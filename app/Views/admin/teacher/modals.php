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
                <button type="button" class="btn text-white" style="background-color: #e8630a;" id="btnConfirmCreate">Créer</button>
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
                <button type="button" class="btn text-white" style="background-color: #e8630a;" id="btnConfirmEdit">Enregistrer</button>
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
<div class="modal fade" id="modalDeletedTeachers" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formateurs supprimés</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover w-100">
                    <thead>
                        <tr>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="deletedTeachersList"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>