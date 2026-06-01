<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SessionModel;
use CodeIgniter\HTTP\RedirectResponse;

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
        $sessionModel = new SessionModel();
        $sessions = $sessionModel->where('id_formation', $id_formation)->findAll();
     
        return view('admin/session/index', ['sessions' => $sessions, 'id_formation' => $id_formation]);
    }
    /**
     * Récupère les données du formulaire de création d'une session et
     * crée une nouvelle session pour la formation adéquate 
     * dans la base de données avec ces données
     *
     * @param integer $id_formation
     * @return RedirectResponse
     */
    function createSession(int $id_formation) : RedirectResponse {
        $rules = [
            'date_debut' => 'required|valid_date',
            'date_fin' => 'required|valid_date',
            'prix' => 'required|regex_match[/^\d+(\.\d{1,2})?$/]|greater_than[0]',
            'id_formateur' => 'required|integer',
            'id_formation' => 'required|integer',
            'id_modalite' => 'required|integer',
        ];
        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('error', 'Données invalides.');
        }
    
        $data = [
            'date_debut' => $this->request->getPost('date_debut'),
            'date_fin' => $this->request->getPost('date_fin'),
            'prix' => $this->request->getPost('prix'),
            'id_formateur' => $this->request->getPost('id_formateur'),
            'id_formation' => $id_formation,
            'id_modalite' => $this->request->getPost('id_modalite'),
        ];

        $sessionModel = new SessionModel();
        $sessionModel->insert($data);

        return redirect()->to("/admin/session/index/$id_formation");
    }
    /**
     * Récupère les données du formulaire de mise à jour d'une session et
     * met à jour la session correspondante pour la formation adéquate
     * dans la base de données
     *
     * @param integer $id_formation
     * @return RedirectResponse
     */
    function updateSession(int $id_formation) : RedirectResponse {
        $rules = [
            'date_debut' => 'required|valid_date',
            'date_fin' => 'required|valid_date',
            'prix' => 'required|regex_match[/^\d+(\.\d{1,2})?$/]|greater_than[0]',
            'id_formateur' => 'required|integer',
            'id_formation' => 'required|integer',
            'id_modalite' => 'required|integer',
        ];
        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('error', 'Données invalides.');
        }
    
        $data = [
            'date_debut' => $this->request->getPost('date_debut'),
            'date_fin' => $this->request->getPost('date_fin'),
            'prix' => $this->request->getPost('prix'),
            'id_formateur' => $this->request->getPost('id_formateur'),
            'id_formation' => $id_formation,
            'id_modalite' => $this->request->getPost('id_modalite'),
        ];

        $sessionModel = new SessionModel();
        $sessionModel->update($this->request->getPost('id_session'), $data);

        return redirect()->to("/admin/session/index/$id_formation");
    }
    /**
     * Supprime une session spécifique d'une formation
     * 
     * Côté JS la vue lui demande confirmation avant de faire la requete de suppression
     *
     * @param integer $id_formation l'id de la formation où se trouve la session à supprimer
     * @return RedirectResponse
     */
    function deleteSession(int $id_formation) : RedirectResponse {
        $sessionModel = new SessionModel();
        $sessionModel->delete($this->request->getPost('id_session'));

        return redirect()->to("/admin/session/index/$id_formation");
    }
}