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
        $this->teacherId = (int) session()->get('user_id');

        if (session()->get('role') !== 'formateur') {
            session()->destroy();
            header('Location: ' . site_url('/login'));
            exit();
        }
    }
    /**
     * Point d'entrée pour le dashboard du formateur
     *
     * @return string la vue du dashboard du formateur
     */
    function index() :string {
        $data = [
            'nom' => session()->get('nom'),
            'prenom' => session()->get('prenom'),
            'email' => session()->get('email'),
            'pageTitle' => 'Mon tableau de bord'
        ];
        return view('teacher/dashboard/index', $data);
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
                    ->getPlanningFormateur($this->teacherId), 'pageTitle' => 'Mon planning']);
    }  
}