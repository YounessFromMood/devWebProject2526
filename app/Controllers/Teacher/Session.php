<?php 

namespace App\Controllers\Teacher;

use App\Controllers\BaseController;
use App\Models\SessionModel;

class Session extends BaseController {

    function updateLink(int $sessionId, string $link):\CodeIgniter\HTTP\RedirectResponse {
        $sessionModel = new SessionModel();
        $result =$sessionModel->updateLink($sessionId, $link);
        if(!$result){
            return redirect()->to("/session/$sessionId")->with('error', "Une erreur s'est produite.");
        }
        
        return redirect()->to("/session/$sessionId")->with('success', "Le lien a été mis à jour avec succès.");
    }

    function deleteLink(int $sessionId) :\CodeIgniter\HTTP\RedirectResponse {
        $sessionModel = new SessionModel();
        $result = $sessionModel->deleteLink($sessionId);
        if(!$result){
            return redirect()->to("/session/$sessionId")->with('error', "Il n'existe pas de lien pour cette session ou une erreur s'est produite.");
        }

        return redirect()->to("/session/$sessionId")->with('success', "Le lien a été supprimé avec succès.");
    }
}