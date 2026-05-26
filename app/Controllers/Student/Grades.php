<?php 

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\NotifierModel;

class Grades extends BaseController {

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
     * Affiche la liste des notes de l'étudiant pour chaque session suivie
     * - Réussite
     * - A participé
     * - En cours (Par défaut: si la session n'est pas encore terminée
     *             ou que le formateur n'a pas encore mis les notes);
     *
     * @return string La vue avec toutes les notes de l'étudiant
     *                pour chaque session suivie
     */
    function index() :string {
        $notifierModel = new NotifierModel();
        $grades = $notifierModel->getGradesForStudent($this->studentId);

        return view('student/grades', ['grades' => $grades]);
    }

}