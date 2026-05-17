<?php

namespace App\Models;

class TyperModel extends UserModel {
    protected $table = 'Typer';
    protected $primaryKey = 'id_formation, id_type_formation';
    protected $returnType = 'integer';
    protected $allowedFields = [];
}