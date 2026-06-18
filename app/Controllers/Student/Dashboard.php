<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\InscriptionModel;
use App\Models\SessionModel;

class Dashboard extends BaseController {

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
        $this->studentId = (int) session()->get('user_id');

        if (session()->get('role') !== 'eleve') {
            session()->destroy();
            header('Location: ' . site_url('/login'));
            exit();
        }
    }
    /**
     * Point d'entrée pour le dashboard de l'étudiant 
     *      
     * @return string La vue du dashboard étudiant
     */
    function index() :string {
        $data = [
            'nom' => session()->get('nom'),
            'prenom' => session()->get('prenom'),
            'email' => session()->get('email'),
            'pageTitle' => 'Mon tableau de bord'
        ];
        return view('student/dashboard/index', $data);
    }
    /** Affiche tous les cours que l'étudiant suit 
     *  et qui ne sont pas terminés
     * 
     *  @return string La vue des cours de l'étudiant
     *                 Avec en données les titres, descriptions,
     *                 dates de début et de fin    
     */
    function courses() :string {
        $sessionModel = new SessionModel();
        return view('student/dashboard/courses',
                    ['sessions' => $sessionModel
                    ->getAllStudentSessions($this->studentId), 'pageTitle' => 'Mes cours']);
    }
    /** Affiche le planning de l'étudiant
     * -> Correspond a toute l'étendue qu'une session dure
     * 
     *  @return string La vue du planning de l'étudiant
     *                 Avec en données les dates de début et de fin 
     *                 de chaque session
     */
    function planning() :string {
        $inscriptionModel = new InscriptionModel();
        return view('student/dashboard/planning', 
                    ['planning' => $inscriptionModel
                    ->getPlanningEtudiant($this->studentId), 'pageTitle' => 'Mon planning']);
    }  
}