<?php 

namespace App\Controllers;

use App\Models\SessionModel;
use App\Models\InscriptionModel;
use App\Models\ModaliteModel;

class Session extends BaseController {

//ici ça gère uniquement quand tu cliques sur une session en particulier
    /**
     * 
     *
     * @param integer $id
     * @return string
     */
    function index(int $id) :string {
        $session = (new SessionModel())->find($id);
        
        return view('session_index', ['session' => $session]);
    }
    /**
     * Charge la page d'inscription et les informations de la session 
     * @param integer $id la session sur laquelle l'élève a cliqué dessus
     * @return string la vue adéquate
     */
    function registerPage(int $id) :string {

        $session = (new SessionModel())->find($id);
        
        return view('session_index', ['session' => $session]);
    }
    /**
     * Permet l'enregistrement d'un élève a une session si:
     * - la date d'inscription est antérieur a la date de début de session
     * - reste de la place dans la session
     * @param integer $idSession l'id de la sesssion souhaité par l'élève
     * @return \CodeIgniter\HTTP\RedirectResponse redirige vers la page de paiement
     * Soit 
     */
    function toRegister(int $idSession) :\CodeIgniter\HTTP\RedirectResponse {
        $idEleve = session()->get('user_id');

        $sessionModel = new SessionModel();
        $sessionData = $sessionModel->find($idSession);

        if(!$idEleve) {
            return redirect()->back()->with('error', "Vous devez être connecté pour vous inscrire à une session.");
        }
        //check date de la session
        $today = new \DateTime();
        $dateDebut = new \DateTime($sessionData['date_debut']);

        if($today >= $dateDebut) {
            return redirect()->back()->with('error', "Cette session à déjà commencé.");
        }
        //check nb places restantes
        $modaliteModel = new ModaliteModel();
        $modalite = $modaliteModel->find($sessionData['id_modalite']);
        $placesMax = $modalite['nb_etudiant_max'];

        $inscrits = (new InscriptionModel())->where('id_session', $idSession)->countAllResults();

        if($inscrits >= $placesMax) {
            return redirect()->back()->with('error', "Cette session est complète.");
        }
        //ajout du goy quand tout est ok
        $data = [
            'id_session' => $idSession,
            'id_eleve' => $idEleve,
        ];

        $inscriptionModel = new InscriptionModel();
        $inscriptionModel->insert($data);
        
        return redirect()->to("/payment/$idSession");
    }
    /**
     * Gère la desinscription d'un élève si
     * - La date de début de session est ultérieure 
     *   à la date de demande de désinscription
     *
     * @param integer $idSession la session dont l'élève veut se désinscrire
     * @return \CodeIgniter\HTTP\RedirectResponse retourne sur:
     * - la page d'accueil si désinscription avec un message personnalisé
     * - le login si l'utilisateur n'est pas connecté ou n'est pas un eleve
     */
    function unsubscribe(int $idSession) :\CodeIgniter\HTTP\RedirectResponse {
       $idEleve = session()->get('user_id');

        if(!$idEleve) {
            return redirect()->back()->with('error', "Vous devez être connecté pour vous désinscrire d'une session.");
        }

        $sessionModel = new SessionModel();
        $sessionDate = $sessionModel->find($idSession);

        $today = new \DateTime();
        $dateDebut = new \DateTime($sessionDate['date_debut']);

        if($today >= $dateDebut) {
            return redirect()->back()->with('error', "Désinscription impossible. Cette session à déjà débuté.");
        }

        $diff = $today->diff($dateDebut);
        $joursRestants = (int) $diff->days;

        if ($joursRestants >= 30) {
            $remboursement = 100;
        } elseif ($joursRestants >= 14) {
            $remboursement = 75;
        } elseif ($joursRestants >= 7) {
            $remboursement = 50;
        } else {
            $remboursement = 25;
        }

        $inscriptionModel = new InscriptionModel();
        $inscriptionModel->deleteRegistration($idEleve, $idSession);

        return redirect()->to("/")->with('success', "Vous avez bien été désinscrit. Vous allez recevoir un remboursement de $remboursement %"); 
    }
}