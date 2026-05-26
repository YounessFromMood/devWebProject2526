<?php

namespace App\Models;

class SessionModel extends UserModel {
    protected $table = 'session';
    protected $primaryKey = 'id_session';
    protected $returnType = 'array';
    protected $allowedFields = ['id_formateur', 'id_formation','id_modalite', 'date_debut', 'date_fin', 'prix'];

    public function getAllSessionsDetails(int $studentId) : array {
        return $this
            ->select('session.*, formation.titre as formation_titre, formateur.nom as formateur_nom, modalite.libelle as modalite_libelle')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->join('formateur', 'formateur.id_formateur = session.id_formateur')
            ->join('modalite', 'modalite.id_modalite = session.id_modalite')
            ->join('S_inscrire', 'S_inscrire.id_session = session.id_session')
            ->where('S_inscrire.id_eleve', $studentId)
            ->findAll();
    }
}
