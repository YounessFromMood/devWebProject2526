<?php

namespace App\Models;

class FormateurModel extends UserModel {
    protected $table = 'formateur';
    protected $primaryKey = 'id_formateur';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'prenom', 'email', 'mdp', 'num_tel'];
}