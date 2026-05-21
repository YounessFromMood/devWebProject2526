<?php

namespace App\Models;

use App\Models\UserModel;

class FormationModel extends UserModel {

    protected $table = 'formation';
    protected $primaryKey = 'id_formation';
    protected $returnType = 'array';
    protected $allowedFields = ['titre', 'description', 'duree', 'prix', 'langue'];
    
    public function search(array $filtres) {
    $builder = $this->db->table('formation');
    $builder->join('Typer', 'Typer.id_formation = formation.id_formation')
            ->join('type_formation', 'type_formation.id_type_formation = Typer.id_type_formation')
            ->select('formation.*, type_formation.libelle AS type_libelle');

    if (!empty($filtres['titre'])) {
        $builder->like('formation.titre', $filtres['titre']);
    }
    if (!empty($filtres['langue'])) {
        $builder->where('formation.langue', $filtres['langue']);
    }
    if (!empty($filtres['prix_max'])) {
        $builder->where('formation.prix <=', $filtres['prix_max']);
    }
    if (!empty($filtres['duree'])) {
        $builder->where('formation.duree', $filtres['duree']);
    }
    if (!empty($filtres['id_type_formation'])) {
        $builder->whereIn('Typer.id_type_formation', $filtres['id_type_formation']);
    }

    return $builder->get()->getResultArray();
}
}