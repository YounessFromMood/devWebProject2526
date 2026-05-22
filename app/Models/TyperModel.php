<?php

namespace App\Models;

class TyperModel extends UserModel {
    protected $table = 'Typer';
    protected $returnType = 'array';
    protected $allowedFields = ['id_formation', 'id_type_formation'];
    protected $useAutoIncrement = false;
}