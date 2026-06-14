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
            ->select('session.*, formation.titre as formation_titre, formateur.nom as formateur_nom, modalite.libelle as modalite_libelle, S_inscrire.paiement_recu')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->join('formateur', 'formateur.id_formateur = session.id_formateur')
            ->join('modalite', 'modalite.id_modalite = session.id_modalite')
            ->join('S_inscrire', 'S_inscrire.id_session = session.id_session')
            ->where('S_inscrire.id_eleve', $studentId)
            ->where('session.date_fin >=', date('Y-m-d')) 
            ->findAll();
    }

    public function getTeacherHistory(int $teacherId): array {
        return $this
            ->select('session.*, formation.titre as formation_titre, modalite.libelle as modalite_libelle')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->join('modalite', 'modalite.id_modalite = session.id_modalite')
            ->where('session.id_formateur', $teacherId)
            ->where('session.date_fin <', date('Y-m-d'))
            ->orderBy('session.date_fin', 'DESC')
            ->findAll();
    }

    public function getTeacherPlanning(int $teacherId): array {
        return $this
            ->select('formation.titre AS formation_titre, session.date_debut, session.date_fin, modalite.libelle AS modalite_libelle, session.lieu_session')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->join('modalite', 'modalite.id_modalite = session.id_modalite')
            ->where('session.id_formateur', $teacherId)
            ->findAll();
    }

    public function getAllTeacherSessions(int $teacherId) : array {
        return $this
            ->select('session.*, formation.titre as formation_titre, modalite.libelle as modalite_libelle')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->join('modalite', 'modalite.id_modalite = session.id_modalite')
            ->where('session.id_formateur', $teacherId)
            ->where('session.date_fin >=', date('Y-m-d'))
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
                    modalite.nb_etudiant_max AS nb_etudiant_max') 
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
            ->onlyDeleted() 
            ->findAll();
    }
 
    function restore(int $id_session): void {
        $this->db->table('session')
            ->where('id_session', $id_session)
            ->update(['deleted_at' => null]);
    }

    public function getStudentHistory(int $studentId) : array {
        return $this
            ->select('session.*, formation.titre as formation_titre, formateur.nom as formateur_nom, modalite.libelle as modalite_libelle, note_reussite.libelle as note_libelle')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->join('formateur', 'formateur.id_formateur = session.id_formateur')
            ->join('modalite', 'modalite.id_modalite = session.id_modalite')
            ->join('S_inscrire', 'S_inscrire.id_session = session.id_session')
            ->join('notifier', 'notifier.id_session = session.id_session AND notifier.id_eleve = S_inscrire.id_eleve', 'left')
            ->join('note_reussite', 'note_reussite.id_note_reussite = notifier.id_note_reussite', 'left')
            ->where('S_inscrire.id_eleve', $studentId)
            ->where('session.date_fin <', date('Y-m-d'))
            ->orderBy('session.date_fin', 'DESC')
            ->findAll();
    }

    public function getSessionsDisponibles(int $id_formation): array {
        return $this
            ->select('session.*, formateur.nom AS formateur_nom, formateur.prenom AS formateur_prenom, modalite.libelle AS modalite_libelle, modalite.nb_etudiant_max AS nb_etudiant_max')
            ->join('formateur', 'formateur.id_formateur = session.id_formateur')
            ->join('modalite', 'modalite.id_modalite = session.id_modalite')
            ->where('session.id_formation', $id_formation)
            ->where('session.date_debut >', date('Y-m-d'))
            ->orderBy('session.date_debut', 'ASC')
            ->findAll();
    }
 
    public function countInscrits(int $id_session): int {
        return $this->db->table('S_inscrire')
            ->where('id_session', $id_session)
            ->countAllResults();
    }

    public function getSessionsDisponibles_byId(int $id_session): ?array{
        $result = $this
            ->select('session.*, formateur.nom AS formateur_nom, formateur.prenom AS formateur_prenom, modalite.libelle AS modalite_libelle, modalite.nb_etudiant_max AS nb_etudiant_max, formation.titre AS formation_titre')
            ->join('formateur', 'formateur.id_formateur = session.id_formateur')
            ->join('modalite', 'modalite.id_modalite = session.id_modalite')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->where('session.id_session', $id_session)
            ->where('session.date_debut >', date('Y-m-d'))
            ->first();

        return $result ?: null;
    }
}