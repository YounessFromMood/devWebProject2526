<?php

namespace App\Models;

class SessionModel extends UserModel {
    protected $table = 'session';
    protected $primaryKey = 'id_session';
    protected $returnType = 'array';
    protected $allowedFields = ['id_formateur', 'id_formation','id_modalite', 'date_debut', 'date_fin', 'prix', 'lieu_session'];
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';

    public function getAllStudentSessions(int $studentId) : array {
        return $this
            ->select('session.*, formation.titre as formation_titre, formateur.nom as formateur_nom, modalite.libelle as modalite_libelle')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->join('formateur', 'formateur.id_formateur = session.id_formateur')
            ->join('modalite', 'modalite.id_modalite = session.id_modalite')
            ->join('S_inscrire', 'S_inscrire.id_session = session.id_session')
            ->where('S_inscrire.id_eleve', $studentId)
            ->findAll();
    }

    public function getAllTeacherSessions(int $teacherId) : array {
        return $this
            ->select('session.*, formation.titre as formation_titre, modalite.libelle as modalite_libelle')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->join('modalite', 'modalite.id_modalite = session.id_modalite')
            ->where('session.id_formateur', $teacherId)
            ->findAll();
    }

    public function getAllStudentsFromSession(int $sessionId) : array {
        return $this
            ->select('eleve.*, inscription.date_inscription')
            ->join('S_inscrire as inscription', 'inscription.id_session = session.id_session')
            ->join('eleve', 'eleve.id_eleve = inscription.id_eleve')
            ->where('session.id_session', $sessionId)
            ->findAll();
    }

    public function updateLink(int $sessionId, string $location) : bool {
        $session = $this->find($sessionId);
        if (!$session) {
            return false;
        }

        $session['lieu_session'] = $location;
        return $this->update($sessionId, $session);
    }

    public function deleteLink(int $sessionId) : bool {
        $session = $this->find($sessionId);
        if (!$session) {
            return false;
        }

        $session['lieu_session'] = null;
        return $this->update($sessionId, $session);
    }

    function getSessionsWithDetails(int $id_formation): array {
        return $this
            ->select('session.*, 
                    formateur.nom       AS formateur_nom,
                    formateur.prenom    AS formateur_prenom,
                    modalite.libelle    AS modalite_libelle,
                    modalite.nb_etudiant_max AS nb_etudiant_max') // ← ajouter ça
            ->join('formateur', 'formateur.id_formateur = session.id_formateur')
            ->join('modalite',  'modalite.id_modalite   = session.id_modalite')
            ->where('session.id_formation', $id_formation)
            ->findAll();
    }
 
    function getDeletedSessionsWithDetails(int $id_formation): array {
        return $this
            ->select('session.*, 
                      formateur.nom       AS formateur_nom,
                      formateur.prenom    AS formateur_prenom,
                      modalite.libelle    AS modalite_libelle')
            ->join('formateur', 'formateur.id_formateur = session.id_formateur')
            ->join('modalite',  'modalite.id_modalite   = session.id_modalite')
            ->where('session.id_formation', $id_formation)
            ->onlyDeleted()   // ← inverse le filtre : ne retourne QUE les lignes avec deleted_at non null
            ->findAll();
    }
 
    function restore(int $id_session): void {
        $this->db->table('session')
            ->where('id_session', $id_session)
            ->update(['deleted_at' => null]);
    }
}
