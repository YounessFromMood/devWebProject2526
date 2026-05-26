<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\InscriptionModel;

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
        $this->studentId = session()->get('user_id');
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
        ];
        return view('student/dashboard', $data);
    }
    /** Affiche tous les cours que l'étudiant suit 
     *  et qui ne sont pas terminés
     * 
     *  @return string La vue des cours de l'étudiant
     *                 Avec en données les titres, descriptions,
     *                 dates de début et de fin    
     */
    function courses() :string {
        $inscriptionModel = new InscriptionModel();

        $data['cours'] = $inscriptionModel
            ->select('session.*, formation.titre, formation.description')
            ->join('session', 'session.id_session = S_inscrire.id_session')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->where('S_inscrire.id_eleve', $this->studentId)
            ->where('session.date_fin >=', date('Y-m-d'))
            ->findAll();
            
        return view('student/dashboard/courses', $data);
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

        $data['planning'] = $inscriptionModel
            ->select('session.*, formation.titre')
            ->join('session', 'session.id_session = S_inscrire.id_session')
            ->join('formation', 'formation.id_formation = session.id_formation')
            ->where('S_inscrire.id_eleve', $this->studentId)
            ->where('session.date_debut >=', date('Y-m-d')) // uniquement les cours à venir
            ->orderBy('session.date_debut', 'ASC') // du plus proche au plus lointain
            ->findAll();

        return view('student/dashboard/planning');
    }
    
}