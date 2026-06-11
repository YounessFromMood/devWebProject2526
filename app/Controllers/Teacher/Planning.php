<?php

namespace App\Controllers\Teacher;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\SessionModel;

class Planning extends BaseController {

    private int $teacherId;

    public function initController(RequestInterface $request,
                                   ResponseInterface $response,
                                   LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->teacherId = session()->get('user_id');
    }
    /**
     * Affiche le planning des sessions à venir de l'enseignant connecté
     *
     * @return string la vue contenant tous les détails 
     *                des sessions à venir de l'enseignant
     */
    public function index()
    {
        $sessionModel = new SessionModel();
        $sessions = $sessionModel->getTeacherPlanning($this->teacherId);

        if ($this->request->hasHeader('X-Requested-With')) {
            return view('teacher/planning', ['sessions' => $sessions]);
        }

        return redirect()->to(base_url('teacher/dashboard'));
    }
}