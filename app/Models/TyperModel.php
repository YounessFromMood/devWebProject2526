<?php

namespace App\Models;

class TyperModel extends UserModel {
    protected $table = 'Typer';
    protected $returnType = 'array';
    protected $allowedFields = ['id_formation', 'id_type_formation'];
    protected $useAutoIncrement = false;

    public function getTypesByFormation(int $idFormation): array {
        return $this
            ->select('type_formation.libelle')
            ->join('type_formation', 'type_formation.id_type_formation = Typer.id_type_formation')
            ->where('Typer.id_formation', $idFormation)
            ->findAll();
    }
}