<?php

namespace App\Controllers\Teacher;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\InscriptionModel;

class Dashboard extends BaseController {

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
     * Point d'entrée pour le dashboard du formateur
     *
     * @return string la vue du dashboard du formateur
     */
    function index() :string {
        return view('teacher/dashboard');
    }

    /** Affiche le planning du formateur
     * -> Correspond a toute l'étendue qu'une session dure
     * 
     *  @return string La vue du planning du formateur
     *                 Avec en données les dates de début et de fin 
     *                 de chaque session
     */
    function planning() :string {
        $inscriptionModel = new InscriptionModel();

        return view('teacher/dashboard/planning', 
                    ['planning' => $inscriptionModel
                    ->getPlanningFormateur($this->teacherId)]);
    }  
}