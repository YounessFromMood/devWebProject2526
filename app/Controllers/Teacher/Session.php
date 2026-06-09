<?php

namespace App\Controllers\Teacher;

use App\Controllers\BaseController;
use App\Models\SessionModel;
use App\Models\NotifierModel;

class Session extends BaseController
{
    public function index()
    {
        $sessionModel = new SessionModel();

        $sessions = $sessionModel->getAllTeacherSessions(session('user_id'));

        if ($this->request->hasHeader('X-Requested-With')) {
            return view('teacher/sessions/index', ['sessions' => $sessions]);
        }

        return redirect()->to(base_url('teacher/dashboard'));
    }

    public function getStudents(int $idSession)
    {
        $notifierModel = new NotifierModel();

        $students = $notifierModel->getStudentsWithGrades($idSession);

        return $this->response->setJSON([
            'success' => true,
            'data'    => $students,
        ]);
    }

    public function createLink(int $idSession, string $link)
    {
        $sessionModel = new SessionModel();

        $ok = $sessionModel->updateLink($idSession, urldecode($link));

        return $this->response->setJSON(['success' => $ok]);
    }

    public function updateLink(int $idSession, string $link)
    {
        $sessionModel = new SessionModel();

        $ok = $sessionModel->updateLink($idSession, urldecode($link));

        return $this->response->setJSON(['success' => $ok]);
    }

    public function deleteLink(int $idSession, string $link)
    {
        $sessionModel = new SessionModel();

        $ok = $sessionModel->deleteLink($idSession);

        return $this->response->setJSON(['success' => $ok]);
    }
}