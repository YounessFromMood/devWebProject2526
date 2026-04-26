<?php

namespace App\Models;

class ModaliteModel extends UserModel {
    protected $table = 'modalite';
    protected $primaryKey = 'id_modalite';
    protected $returnType = 'array';
    protected $allowedFields = ['libelle', 'nb_etudiant_max'];
}
