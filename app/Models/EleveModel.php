<?php

namespace App\Models;

class EleveModel extends UserModel {
    protected $table = 'eleve';
    protected $primaryKey = 'id_eleve';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'prenom', 'email', 'mdp', 'num_tel'];
}

