<div class="modal fade" id="modalCreateStudent" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un étudiant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="createStudentError" class="alert alert-danger d-none"></div>
                <div class="mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" id="createStudentPrenom" class="form-control" placeholder="Prénom">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" id="createStudentNom" class="form-control" placeholder="Nom">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" id="createStudentEmail" class="form-control" placeholder="email@exemple.be">
                </div>
                <div class="mb-3">
                    <label class="form-label">Téléphone <span class="text-muted">(optionnel)</span></label>
                    <input type="text" id="createStudentTel" class="form-control" placeholder="+32 470 00 00 00">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" id="createStudentMdp" class="form-control" placeholder="Mot de passe">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn text-white" style="background-color: #e8630a;" id="btnConfirmCreateStudent">Créer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditStudent" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier l'étudiant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="editStudentError" class="alert alert-danger d-none"></div>
                <input type="hidden" id="editStudentId">
                <div class="mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" id="editStudentPrenom" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" id="editStudentNom" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" id="editStudentEmail" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Téléphone <span class="text-muted">(optionnel)</span></label>
                    <input type="text" id="editStudentTel" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nouveau mot de passe <span class="text-muted">(laisser vide pour ne pas changer)</span></label>
                    <input type="password" id="editStudentMdp" class="form-control" placeholder="••••••••">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn text-white" style="background-color: #e8630a;" id="btnConfirmEditStudent">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteStudent" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer <strong id="deleteStudentName"></strong> ?</p>
                <input type="hidden" id="deleteStudentId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDeleteStudent">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeletedStudents" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Étudiants supprimés</h5>
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
                    <tbody id="deletedStudentsList"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>