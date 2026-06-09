<!-- =============================================
     MODAL — Créer une session
     ============================================= -->
<div class="modal fade" id="modalCreateSession" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="createSessionError" class="alert alert-danger d-none"></div>
                <input type="hidden" id="createSessionIdFormation">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Date de début <span class="text-danger">*</span></label>
                        <input type="date" id="createSessionDebut" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date de fin <span class="text-danger">*</span></label>
                        <input type="date" id="createSessionFin" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Formateur <span class="text-danger">*</span></label>
                        <select id="createSessionFormateur" class="form-select">
                            <option value="">— Choisir un formateur —</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Modalité <span class="text-danger">*</span></label>
                        <select id="createSessionModalite" class="form-select">
                            <option value="">— Choisir une modalité —</option>
                        </select>
                        <div id="createSessionMaxInfo" class="form-text d-none">
                            Nombre max d'élèves : <strong id="createSessionMaxVal"></strong>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Prix <span class="text-muted">(optionnel)</span></label>
                        <div class="input-group">
                            <input type="number" id="createSessionPrix" class="form-control" placeholder="ex: 299" min="0" step="0.01">
                            <span class="input-group-text">€</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lieu / Lien <span class="text-muted">(optionnel)</span></label>
                        <input type="text" id="createSessionLieu" class="form-control" placeholder="ex: Salle B3 ou https://...">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn text-white" style="background-color: #e8630a;"
                        id="btnConfirmCreateSession">Créer</button>
            </div>
        </div>
    </div>
</div>

<!-- =============================================
     MODAL — Modifier une session
     ============================================= -->
<div class="modal fade" id="modalEditSession" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="editSessionError" class="alert alert-danger d-none"></div>
                <input type="hidden" id="editSessionId">
                <input type="hidden" id="editSessionIdFormation">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Date de début <span class="text-danger">*</span></label>
                        <input type="date" id="editSessionDebut" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date de fin <span class="text-danger">*</span></label>
                        <input type="date" id="editSessionFin" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Formateur <span class="text-danger">*</span></label>
                        <select id="editSessionFormateur" class="form-select"></select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Modalité <span class="text-danger">*</span></label>
                        <select id="editSessionModalite" class="form-select"></select>
                        <div id="editSessionMaxInfo" class="form-text d-none">
                            Nombre max d'élèves : <strong id="editSessionMaxVal"></strong>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Prix <span class="text-muted">(optionnel)</span></label>
                        <div class="input-group">
                            <input type="number" id="editSessionPrix" class="form-control" min="0" step="0.01">
                            <span class="input-group-text">€</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lieu / Lien <span class="text-muted">(optionnel)</span></label>
                        <input type="text" id="editSessionLieu" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn text-white" style="background-color: #e8630a;"
                        id="btnConfirmEditSession">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<!-- =============================================
     MODAL — Supprimer une session
     ============================================= -->
<div class="modal fade" id="modalDeleteSession" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer la session du <strong id="deleteSessionDate"></strong> ?</p>
                <input type="hidden" id="deleteSessionId">
                <input type="hidden" id="deleteSessionIdFormation">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDeleteSession">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- =============================================
     MODAL — Sessions supprimées
     ============================================= -->
<div class="modal fade" id="modalDeletedSessions" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sessions supprimées</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover w-100">
                    <thead>
                        <tr>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Formateur</th>
                            <th>Modalité</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="deletedSessionsList"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>