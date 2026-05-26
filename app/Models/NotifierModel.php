<?php 

namespace App\Models;

class NotifierModel extends UserModel {
    protected $table = 'notifier';
    protected $returnType = 'array';
    protected $allowedFields = ['id_eleve', 'id_session', 'id_note_reussite'];
    protected $useAutoIncrement = false;

    public function getGradesForStudent(int $studentId) : array {
        return $this
            ->select('notifier.*, session.titre as session_titre, note_reussite.libelle as note_libelle')
            ->join('session', 'session.id_session = notifier.id_session')
            ->join('note_reussite', 'note_reussite.id_note_reussite = notifier.id_note_reussite')
            ->where('notifier.id_eleve', $studentId)
            ->findAll();
    }
}