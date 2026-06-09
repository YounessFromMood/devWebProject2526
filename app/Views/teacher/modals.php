<!-- Voir les étudiants d'une session -->
<div class="modal fade" id="modalSessionStudents" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Étudiants de la session</h5>
                    <small class="text-muted" id="modalSessionStudentsSubtitle"></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="currentSessionId">
                <div id="sessionStudentsError" class="alert alert-danger d-none"></div>
                <table class="table table-hover w-100" id="dataTableSessionStudents">
                    <thead>
                        <tr>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Note</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sessionStudentsList"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Attribuer une note -->
<div class="modal fade" id="modalCreateGrade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attribuer une note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="createGradeError" class="alert alert-danger d-none"></div>
                <input type="hidden" id="createGradeIdSession">
                <input type="hidden" id="createGradeIdEleve">
                <p class="mb-3">Étudiant : <strong id="createGradeEtudiantName"></strong></p>
                <div class="mb-3">
                    <label class="form-label">Note <span class="text-danger">*</span></label>
                    <select id="createGradeNote" class="form-select">
                        <option value="">— Choisir une note —</option>
                        <option value="Réussite">Réussite</option>
                        <option value="A participé">A participé</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn text-white" style="background-color: #e8630a;"
                        id="btnConfirmCreateGrade">Attribuer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modifier une note -->
<div class="modal fade" id="modalEditGrade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="editGradeError" class="alert alert-danger d-none"></div>
                <input type="hidden" id="editGradeIdSession">
                <input type="hidden" id="editGradeIdEleve">
                <p class="mb-3">Étudiant : <strong id="editGradeEtudiantName"></strong></p>
                <div class="mb-3">
                    <label class="form-label">Note <span class="text-danger">*</span></label>
                    <select id="editGradeNote" class="form-select">
                        <option value="">— Choisir une note —</option>
                        <option value="Réussite">Réussite</option>
                        <option value="A participé">A participé</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn text-white" style="background-color: #e8630a;"
                        id="btnConfirmEditGrade">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<!-- Gérer le lieu / lien d'une session -->
<div class="modal fade" id="modalSessionLink" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Lieu / Lien de la session</h5>
                    <small class="text-muted" id="modalSessionLinkSubtitle"></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="sessionLinkError" class="alert alert-danger d-none"></div>
                <input type="hidden" id="linkSessionId">
                <div class="mb-3">
                    <label class="form-label">Lieu ou lien <span class="text-danger">*</span></label>
                    <input type="text" id="linkSessionValue" class="form-control"
                           placeholder="ex: Salle B3 ou https://meet.google.com/...">
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-danger" id="btnDeleteLink">
                    Supprimer le lien
                </button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn text-white" style="background-color: #e8630a;"
                            id="btnConfirmSaveLink">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Supprimer une note -->
<div class="modal fade" id="modalDeleteGrade" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supprimer la note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer la note de <strong id="deleteGradeEtudiantName"></strong> ?</p>
                <input type="hidden" id="deleteGradeIdSession">
                <input type="hidden" id="deleteGradeIdEleve">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDeleteGrade">Supprimer</button>
            </div>
        </div>
    </div>
</div>