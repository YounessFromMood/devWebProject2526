<?php

namespace App\Models;

class AdminModel extends UserModel {
    protected $table = 'administrateur';
    protected $primaryKey = 'id_administrateur';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'prenom', 'email', 'mdp', 'num_tel'];
}