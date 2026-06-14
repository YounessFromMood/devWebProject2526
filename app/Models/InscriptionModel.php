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

    public function signalPayment(int $studentId, int $sessionId) : bool {
        return $this
            ->where('id_eleve', $studentId)
            ->where('id_session', $sessionId)
            ->set(['paiement_recu' => 1])
            ->update();
    }

    public function confirmPayment(int $studentId, int $sessionId) : bool {
        return $this
            ->where('id_eleve', $studentId)
            ->where('id_session', $sessionId)
            ->set(['paiement_recu' => 2])
            ->update();
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
            ->select('S_inscrire.*, session.prix, session.date_debut, formation.titre, eleve.nom AS nom_eleve')
            ->join('session', 'session.id_session = S_inscrire.id_session')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->join('eleve', 'eleve.id_eleve = S_inscrire.id_eleve')
            ->findAll();
    }

    public function inscrire(int $idEleve, int $idSession): bool{
        return $this->db->table('S_inscrire')->insert([
            'id_eleve'         => $idEleve,
            'id_session'       => $idSession,
            'paiement_recu'    => 0,
            'date_inscription' => date('Y-m-d'),
        ]);
    }

    public function getIdSessionsByEleve(int $idEleve): array{
        $inscriptions = $this->where('id_eleve', $idEleve)->findAll();
        return array_column($inscriptions, 'id_session');
    }
}