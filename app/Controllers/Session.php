<?php 

namespace App\Controllers;

use App\Models\SessionModel;
use App\Models\InscriptionModel;
use App\Models\ModaliteModel;

class Session extends BaseController {

//TODO faire un join dans formation pour récuperer juste les dates de session
//ici ça gère uniquement quand tu cliques sur une session en particulier

    function registerPage(int $id) :string {

        $session = new SessionModel()->find($id);
        
        return view('session_index', ['session' => $session]);
    }
    /**
     * Permet l'enregistrement d'un élève a une session si:
     * - la date d'inscription est antérieur a la date de début de session
     * - reste de la place dans la session
     * @param integer $idSession l'id de la sesssion souhaité par l'élève
     * @return \CodeIgniter\HTTP\RedirectResponse 
     * Soit 
     */
    function toRegister(int $idSession) :\CodeIgniter\HTTP\RedirectResponse {
        $idEleve = session()->get('user_id');

        $sessionModel = new SessionModel();
        $sessionData = $sessionModel->find($idSession);

        if(!$idEleve) {
            return redirect()->to("/login/$idSession");
        }

        //TODO check la date de début + nombre de place restante
        //check date de la session
        $today = new \DateTime();
        $dateDebut = new \DateTime($sessionData['date_debut']);

        if($today >= $dateDebut) {
            return redirect()->to("/")->with('error', "Cette session à déjà commencé.");
        }
        //check nb places restantes
        $modaliteModel = new ModaliteModel();
        $modalite = $modaliteModel->find($sessionData['id_modalite']);
        $placesMax = $modalite['nb_etudiant_max'];

        $inscrits = new InscriptionModel()->where('id_session', $idSession)->countAllResults();

        if($inscrits >= $placesMax) {
            return redirect()->to("/")->with('error', "Cette session est complète.");
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
     * @return \CodeIgniter\HTTP\RedirectResponse retourne sur la page d'accueil si désinscription
     */
    function unsubscribe(int $idSession) :\CodeIgniter\HTTP\RedirectResponse {
       $idEleve = session()->get('user_id');

        if(!$idEleve) {
            return redirect()->to("/login/$idSession");
        }

        $sessionModel = new SessionModel();
        $sessionDate = $sessionModel->find($idSession);

        $today = new \DateTime();
        $dateDebut = new \DateTime($sessionDate['date_debut']);

        if($today >= $dateDebut) {
            return redirect()->to("/")->with('error', "Désinscription impossible. Cette session à déjà débuté.");
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
        $inscriptionModel->where('id_eleve', $idEleve)
                         ->where('id_session', $idSession)
                         ->delete();

        return redirect()->to("/")->with('success', "Vous avez bien été désinscrit. Vous allez recevoir un remboursement de $remboursement %"); 
    }
}