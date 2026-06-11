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

    /**
     * Retourne tous les étudiants inscrits à une session
     * avec leur note de réussite (null si pas encore notés).
     */
    public function getStudentsWithGrades(int $sessionId) : array {
        return $this->db->table('S_inscrire')
            ->select('eleve.id_eleve, eleve.nom, eleve.prenom, eleve.email, note_reussite.libelle as note_libelle')
            ->join('eleve', 'eleve.id_eleve = S_inscrire.id_eleve')
            ->join('notifier', 'notifier.id_eleve = S_inscrire.id_eleve AND notifier.id_session = S_inscrire.id_session', 'left')
            ->join('note_reussite', 'note_reussite.id_note_reussite = notifier.id_note_reussite', 'left')
            ->where('S_inscrire.id_session', $sessionId)
            ->get()
            ->getResultArray();
    }

    public function addGrade(int $studentId, int $sessionId, string $grade) : bool {
        $gradeRecord = $this->db->table('note_reussite')
            ->where('libelle', $grade)
            ->get()
            ->getRowArray();

        if (!$gradeRecord) {
            return false;
        }

        return $this->db->table('notifier')->insert([
            'id_eleve'         => $studentId,
            'id_session'       => $sessionId,
            'id_note_reussite' => $gradeRecord['id_note_reussite']
        ]);
    }

    public function updateGrade(int $studentId, int $sessionId, string $grade) : bool {
        $gradeRecord = $this->db->table('note_reussite')->where('libelle', $grade)->get()->getRowArray();
        if (!$gradeRecord) {
            return false;
        }

        return $this
            ->where('id_eleve', $studentId)
            ->where('id_session', $sessionId)
            ->update(['id_note_reussite' => $gradeRecord['id_note_reussite']]);
    }

    public function deleteGrade(int $studentId, int $sessionId) : bool {
        return $this
            ->where('id_eleve', $studentId)
            ->where('id_session', $sessionId)
            ->delete();
    }
}