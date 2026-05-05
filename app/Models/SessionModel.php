<?php

namespace App\Models;

class SessionModel extends UserModel {
    protected $table = 'session';
    protected $primaryKey = 'id_session';
    protected $returnType = 'array';
    protected $allowedFields = ['id_formateur', 'id_formation','id_modalite', 'date_debut', 'date_fin', 'prix'];
}
