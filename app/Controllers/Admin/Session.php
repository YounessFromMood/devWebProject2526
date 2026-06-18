<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SessionModel;
use App\Models\FormateurModel;
use App\Models\ModaliteModel;
use CodeIgniter\HTTP\ResponseInterface;

class Session extends BaseController{

    /**
     * Affiche le panneau de gestion des sessions d'une formation spécifique,
     * en récupérant les sessions associées à cette formation depuis la base de données
     * et en les passant à la vue correspondante
     *
     * @param integer $id_formation l'id de la formation où l'on veut gérer les sessions
     * @return string la vue affichant la liste des sessions de la formation et les options de I/U/D pour chaque session
     */
    function index(int $id_formation) :string {
        $sessionModel   = new SessionModel();
        $formateurModel = new FormateurModel();
        $modaliteModel  = new ModaliteModel();

        $sessions   = $sessionModel->getSessionsWithDetails($id_formation);
        $formateurs = $formateurModel->findAll();
        $modalites  = $modaliteModel->findAll();

        return view('admin/session/index', [
            'sessions'     => $sessions,
            'formateurs'   => $formateurs,
            'modalites'    => $modalites,
            'id_formation' => $id_formation,
            'pageTitle'    => 'Gestion des sessions',
        ]);
    }

    /**
     * Récupère les données du formulaire de création d'une session et
     * crée une nouvelle session pour la formation adéquate 
     * dans la base de données avec ces données
     *
     * @param integer $id_formation
     * @return ResponseInterface
     */
    function createSession() : ResponseInterface {
        $data = $this->request->getJSON(true);

        if (empty($data['date_debut']) || empty($data['date_fin'])
            || empty($data['id_formateur']) || empty($data['id_modalite'])
            || empty($data['id_formation'])
        ) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Champs obligatoires manquants.',
            ]);
        }

        if ($data['date_fin'] < $data['date_debut']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'La date de fin doit être après la date de début.',
            ]);
        }

        $sessionModel = new SessionModel();
        $sessionModel->insert([
            'date_debut'   => $data['date_debut'],
            'date_fin'     => $data['date_fin'],
            'prix'         => $data['prix']         ?? null,
            'lieu_session' => $data['lieu_session'] ?? null,
            'id_formateur' => $data['id_formateur'],
            'id_formation' => $data['id_formation'],
            'id_modalite'  => $data['id_modalite'],
        ]);

        return $this->response->setJSON(['success' => true]);
    }

    /**
     * Récupère les données du formulaire de mise à jour d'une session et
     * met à jour la session correspondante pour la formation adéquate
     * dans la base de données
     *
     * @param integer $id_formation
     * @return ResponseInterface
     */
    function updateSession() : ResponseInterface {
        $data = $this->request->getJSON(true);

        if (empty($data['id_session'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Session introuvable.',
            ]);
        }

        if (!empty($data['date_debut']) && !empty($data['date_fin'])
            && $data['date_fin'] < $data['date_debut']
        ) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'La date de fin doit être après la date de début.',
            ]);
        }

        $sessionModel = new SessionModel();
        $sessionModel->update($data['id_session'], [
            'date_debut'   => $data['date_debut'],
            'date_fin'     => $data['date_fin'],
            'prix'         => $data['prix']         ?? null,
            'lieu_session' => $data['lieu_session'] ?? null,
            'id_formateur' => $data['id_formateur'],
            'id_modalite'  => $data['id_modalite'],
        ]);

        return $this->response->setJSON(['success' => true]);
    }

    /**
     * Supprime une session spécifique d'une formation
     * 
     * Côté JS la vue lui demande confirmation avant de faire la requete de suppression
     *
     * @param integer $id_formation l'id de la formation où se trouve la session à supprimer
     * @return ResponseInterface
     */
    function deleteSession() : ResponseInterface {
        $data = $this->request->getJSON(true);

        if (empty($data['id_session'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Session introuvable.',
            ]);
        }

        $sessionModel = new SessionModel();
        $sessionModel->delete($data['id_session']);

        return $this->response->setJSON(['success' => true]);
    }

    /**
     * Récupère les sessions soft-deleted d'une formation spécifique
     * et les retourne en JSON
     *
     * @param integer $id_formation
     * @return ResponseInterface
     */
    function getDeleted(int $id_formation) : ResponseInterface {
        $sessionModel = new SessionModel();

        return $this->response->setJSON([
            'success' => true,
            'data'    => $sessionModel->getDeletedSessionsWithDetails($id_formation),
        ]);
    }

    /**
     * Restaure une session précédemment supprimée en remettant
     * son champ deleted_at à NULL dans la base de données
     *
     * @return ResponseInterface
     */
    function restoreSession() : ResponseInterface {
        $data = $this->request->getJSON(true);

        if (empty($data['id_session'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Session introuvable.',
            ]);
        }

        $sessionModel = new SessionModel();
        $sessionModel->restore((int) $data['id_session']);

        return $this->response->setJSON(['success' => true]);
    }
}