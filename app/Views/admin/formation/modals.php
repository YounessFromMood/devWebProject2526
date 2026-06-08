<!-- Modal Créer -->
<div class="modal fade" id="modalCreateFormation" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une formation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="createFormationError" class="alert alert-danger d-none"></div>
                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" id="createFormationTitre" class="form-control" placeholder="Titre de la formation">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea id="createFormationDescription" class="form-control" rows="4" placeholder="Description..."></textarea>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">Durée <span class="text-muted">(optionnel)</span></label>
                        <input type="text" id="createFormationDuree" class="form-control" placeholder="ex: 3 jours">
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">Prix <span class="text-muted">(optionnel)</span></label>
                        <input type="number" id="createFormationPrix" class="form-control" placeholder="ex: 299">
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">Langue <span class="text-muted">(optionnel)</span></label>
                        <input type="text" id="createFormationLangue" class="form-control" placeholder="ex: Français">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Type(s) de formation</label>
                    <div id="createFormationTypes" class="d-flex flex-wrap gap-2"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn text-white" style="background-color: #e8630a;" id="btnConfirmCreateFormation">Créer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modifier -->
<div class="modal fade" id="modalEditFormation" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la formation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="editFormationError" class="alert alert-danger d-none"></div>
                <input type="hidden" id="editFormationId">
                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" id="editFormationTitre" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea id="editFormationDescription" class="form-control" rows="4"></textarea>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">Durée <span class="text-muted">(optionnel)</span></label>
                        <input type="text" id="editFormationDuree" class="form-control">
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">Prix <span class="text-muted">(optionnel)</span></label>
                        <input type="number" id="editFormationPrix" class="form-control">
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">Langue <span class="text-muted">(optionnel)</span></label>
                        <input type="text" id="editFormationLangue" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Type(s) de formation</label>
                    <div id="editFormationTypes" class="d-flex flex-wrap gap-2"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn text-white" style="background-color: #e8630a;" id="btnConfirmEditFormation">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Supprimer -->
<div class="modal fade" id="modalDeleteFormation" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer <strong id="deleteFormationTitre"></strong> ?</p>
                <input type="hidden" id="deleteFormationId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDeleteFormation">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Formations supprimées -->
<div class="modal fade" id="modalDeletedFormations" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formations supprimées</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover w-100">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Durée</th>
                            <th>Prix</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="deletedFormationsList"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>