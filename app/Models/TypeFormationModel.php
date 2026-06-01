<?php
namespace App\Models;

class TypeFormationModel extends UserModel {
    protected $table = 'type_formation';
    protected $primaryKey = 'id_type_formation';
    protected $allowedFields = ['libelle'];
    protected $returnType = 'array';
}