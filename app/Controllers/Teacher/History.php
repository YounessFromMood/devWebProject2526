<?php 

namespace App\Controllers\Teacher;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\SessionModel;

class History extends BaseController {

    private int $teacherId;
    /**
     * Quand le controlleur est appelé, 
     * avant toute action elle initialise le user_id
     */
    public function initController(RequestInterface $request,
                                    ResponseInterface $response,
                                    LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->teacherId = session()->get('user_id');
    }
    /**
     * Affiche l'historique des sessions données par l'enseignant connecté
     *
     * @return string la vue contenant tous les détails 
     *                des sessions données par l'enseignant
     */
    function index() :string {
        $sessionModel = new SessionModel();
        $sessions = $sessionModel->getTeacherHistory($this->teacherId);

        return view('teacher/history', ['sessions' => $sessions]);
    }
}