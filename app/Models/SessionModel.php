<?php

namespace App\Models;

class SessionModel extends UserModel {
    protected $table = 'session';
    protected $primaryKey = 'id_session';
    protected $returnType = 'array';
    protected $allowedFields = ['id_formateur', 'id_formation','id_modalite', 'date_debut', 'date_fin', 'prix', 'lieu_session'];

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
}
