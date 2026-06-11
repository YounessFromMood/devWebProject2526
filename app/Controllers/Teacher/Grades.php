<?php 

namespace App\Controllers\Teacher;

use App\Controllers\BaseController;
use App\Models\SessionModel;
use \App\Models\NotifierModel;

class Grades extends BaseController {

    public function index() :string{
        $sessionModel = new SessionModel();
        $sessions = $sessionModel->getAllTeacherSessions(session()->get('user_id'));

        return view('teacher/grades', ['sessions' => $sessions]);
    }

    public function getListStudentForSession(int $sessionId) :\CodeIgniter\HTTP\RedirectResponse {
        if (session()->get('role') !== 'teacher' || !session()->get('user_id')) {
            return redirect()->back()->with('error', "Accès refusé.");
        }
        $students = $this->getStudentList($sessionId);

        return redirect()->to('/teacher/grades/list_students/' . $sessionId)->with('students', $students);
    }
    /**
     * Attribue une note a un élève s'il n'en possède pas déjà une
     *
     * @param integer $studentId l'id de l'élève à qui on veut attribuer une note
     * @param integer $sessionId l'id de la session pour laquelle on veut attribuer une note à un élève
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function createGrade(int $sessionId, int $studentId) :\CodeIgniter\HTTP\ResponseInterface {
        $body  = $this->request->getJSON(true);
        $grade = $body['note'] ?? null;

        if (!$grade) {
            return $this->response->setJSON(['success' => false, 'message' => 'Note manquante.']);
        }

        $notifierModel = new NotifierModel();
        $result = $notifierModel->addGrade($studentId, $sessionId, $grade);

        if (!$result) {
            return $this->response->setJSON(['success' => false, 'message' => "Une note existe déjà pour cet élève ou une erreur s'est produite."]);
        }

        return $this->response->setJSON(['success' => true]);
    }
    /**
     * Met à jour la note d'un élève pour une session donnée s'il en possède déjà une
     *
     * @param integer $studentId l'id de l'élève dont on veut mettre à jour la note
     * @param integer $sessionId l'id de la session pour laquelle on veut mettre à jour la note d'un élève
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function updateGrade(int $sessionId, int $studentId) :\CodeIgniter\HTTP\ResponseInterface {
        $body  = $this->request->getJSON(true);
        $grade = $body['note'] ?? null;

        if (!$grade) {
            return $this->response->setJSON(['success' => false, 'message' => 'Note manquante.']);
        }

        $notifierModel = new NotifierModel();
        $result = $notifierModel->updateGrade($studentId, $sessionId, $grade);

        if (!$result) {
            return $this->response->setJSON(['success' => false, 'message' => "Une erreur s'est produite."]);
        }

        return $this->response->setJSON(['success' => true]);
    }
    /**
     * Supprime la note d'un élève pour une session donnée s'il en possède déjà une
     *
     * @param integer $studentId l'id de l'élève dont on veut supprimer la note
     * @param integer $sessionId l'id de la session pour laquelle on veut supprimer la note d'un élève
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function deleteGrade(int $sessionId, int $studentId) :\CodeIgniter\HTTP\ResponseInterface {
        $notifierModel = new NotifierModel();
        $result = $notifierModel->deleteGrade($studentId, $sessionId);

        if (!$result) {
            return $this->response->setJSON(['success' => false, 'message' => "Une erreur s'est produite."]);
        }

        return $this->response->setJSON(['success' => true]);
    }
    /**
     * Fonction qui récupère la liste de tous les étudiants d'une session
     * 
     * @param integer $sessionId l'id de la session
     * @return array
     */
    private function getStudentList(int $sessionId) :array {
        $sessionModel = new SessionModel();
        return $sessionModel->getAllStudentsFromSession($sessionId);
    }
}