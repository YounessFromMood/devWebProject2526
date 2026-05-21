<?php

namespace App\Models;

class NoteReussiteModel extends UserModel {
    protected $table = 'note_reussite';
    protected $primaryKey = 'id_note_reussite';
    protected $returnType = 'array';
    protected $allowedFields = ['libelle'];
}