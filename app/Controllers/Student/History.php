<?php 

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\SessionModel;

class History extends BaseController {

    private int $studentId;
    /**
     * Quand le controlleur est appelé, 
     * avant toute action elle initialise le user_id
     */
    public function initController(RequestInterface $request,
                                    ResponseInterface $response,
                                    LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->studentId = session()->get('user_id');
    }
    /**
     * Affiche l'historique des sessions suivies par l'élève connecté
     *
     * @return string la vue contenant tous les détails 
     *                des sessions suivies par l'élève
     */
    function index() :string {
        $sessionModel = new SessionModel();
        $sessions = $sessionModel->getStudentHistory($this->studentId);

        return view('student/history', ['sessions' => $sessions, 'pageTitle' => 'Mon historique']);
    }
}