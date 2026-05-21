<?php 

namespace App\Models;

class NotifierModel extends UserModel {
    protected $table = 'notifier';
    protected $returnType = 'array';
    protected $allowedFields = ['id_eleve', 'id_session', 'id_note_reussite'];
    protected $useAutoIncrement = false;
}