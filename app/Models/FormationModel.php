<?php

namespace App\Models;

use App\Models\UserModel;

class FormationModel extends UserModel {

    protected $table = 'formation';

    protected $primaryKey = 'id_formation';

    protected $returnType = 'array';

    protected $allowedFields = ['titre', 'description', 'duree', 'prix', 'langue'];
    
}