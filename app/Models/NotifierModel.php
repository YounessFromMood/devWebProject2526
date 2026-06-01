<?php 

namespace App\Models;

class NotifierModel extends UserModel {
    protected $table = 'notifier';
    protected $returnType = 'array';
    protected $allowedFields = ['id_eleve', 'id_session', 'id_note_reussite'];
    protected $useAutoIncrement = false;

    public function getGradesForStudent(int $studentId) : array {
        return $this
            ->select('notifier.*, formation.titre as session_titre, note_reussite.libelle as note_libelle')
            ->join('session', 'session.id_session = notifier.id_session')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->join('note_reussite', 'note_reussite.id_note_reussite = notifier.id_note_reussite')
            ->where('notifier.id_eleve', $studentId)
            ->findAll();
    }

    public function addGrade(int $studentId, int $sessionId, string $grade) : bool {
        $gradeRecord = $this->db->table('note_reussite')->where('libelle', $grade)->get()->getRowArray();
        if (!$gradeRecord) {
            return false; // Note non trouvée
        }

        $data = [
            'id_eleve' => $studentId,
            'id_session' => $sessionId,
            'id_note_reussite' => $gradeRecord['id_note_reussite']
        ];

        return $this->insert($data);
    }

    public function updateGrade(int $studentId, int $sessionId, string $grade) : bool {
        $gradeRecord = $this->db->table('note_reussite')->where('libelle', $grade)->get()->getRowArray();
        if (!$gradeRecord) {
            return false; // Note non trouvée
        }

        $data = [
            'id_note_reussite' => $gradeRecord['id_note_reussite']
        ];

        return $this->where('id_eleve', $studentId)->where('id_session', $sessionId)->update($data);
    }

    public function deleteGrade(int $studentId, int $sessionId) : bool {
        return $this->where('id_eleve', $studentId)->where('id_session', $sessionId)->delete();
    }
}