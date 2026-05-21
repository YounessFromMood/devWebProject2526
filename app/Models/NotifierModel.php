<?php 

namespace App\Models;

class NotifierModel extends UserModel {
    protected $table = 'notifier';
    protected $primaryKey = 'id_eleve, id_session, id_note_reussite';
    protected $returnType = 'array';
    protected $allowedFields = [];
}