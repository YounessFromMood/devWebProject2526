<?php

namespace App\Models;

/**
 * Cette classe interne sert uniquement 
 * d'intermédiaire à mes controllers
 * pour inscrire un élève a une session
 */
class InscriptionModel extends UserModel{
    protected $table = 'S_inscrire';
    protected $returnType = 'array';
    protected $allowedFields = ['id_eleve', 'id_session', 'paiement_recu'];
    protected $useAutoIncrement = false;

    public function getCurrentCourses(int $studentId) : array {
        return $this
            ->select('session.*, formation.titre, formation.description')
            ->join('session', 'session.id_session = S_inscrire.id_session')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->where('S_inscrire.id_eleve', $studentId)
            ->where('session.date_debut <=', date('Y-m-d'))
            ->where('session.date_fin >=', date('Y-m-d'))
            ->findAll();
    }

    public function getPlanningEtudiant(int $studentId) : array {
    return $this
        ->select('session.*, formation.titre')
        ->join('session', 'session.id_session = S_inscrire.id_session')
        ->join('formation', 'formation.id_formation = session.id_formation')
        ->where('S_inscrire.id_eleve', $studentId)
        ->where('session.date_debut >=', date('Y-m-d'))
        ->orderBy('session.date_debut', 'ASC')
        ->findAll();
    }

    public function confirmPayment(int $studentId, int $sessionId) : bool {
        $data = [
            'paiement_recu' => true
        ];
        return $this->update(['id_eleve' => $studentId, 'id_session' => $sessionId], $data);
    }

    public function deleteRegistration(int $studentId, int $sessionId) : bool {
        return $this->where(['id_eleve' => $studentId, 'id_session' => $sessionId])->delete();
    }

    public function getPlanningFormateur(int $teacherId) : array {
        return $this
            ->select('session.*, formation.titre')
            ->join('session', 'session.id_session = S_inscrire.id_session')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->where('session.id_formateur', $teacherId)
            ->where('session.date_debut >=', date('Y-m-d'))
            ->orderBy('session.date_debut', 'ASC')
            ->findAll();
    }

    public function getPendingPayments() : array {
        return $this
            ->select('S_inscrire.*, session.prix, formation.titre, eleve.nom AS nom_eleve')
            ->join('session', 'session.id_session = S_inscrire.id_session')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->join('eleve', 'eleve.id_eleve = S_inscrire.id_eleve')
            ->where('S_inscrire.paiement_recu', false)
            ->findAll();
    }
}