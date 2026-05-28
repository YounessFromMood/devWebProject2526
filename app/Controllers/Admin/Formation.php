<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FormationModel;

class Formation extends BaseController{
    /**
     * Affiche l'interface de gestion des formations, 
     * avec la liste des formations existantes et 
     * les options de I/U/D pour chaque formation
     * 
     * A la fin de chaque formation une option gérer session est affichée,
     * et redirige vers le panel de gestion des sessions de cette formation
     *
     * @return string la vue affichant la liste des formations 
     * et les options de I/U/D pour chaque formation
     */
    function index() :string {
        $formationModel = new FormationModel();
        $formations = $formationModel->findAll();

        return view('admin/formation/index', ['formations' => $formations]);
    }
    /**
     * Récupère les données du formulaire de création d'une formation et
     * crée une nouvelle formation dans la base de données avec ces données
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function createFormation() :\CodeIgniter\HTTP\RedirectResponse {
        $rules = [
            'titre' => 'required|string|min_length[2]|max_length[300]',
            'description' => 'required|string|min_length[2]|max_length[2500]',
            'duree' => 'required|string|min_length[2]|max_length[150]',
            'prix' => 'required|regex_match[/^\d+(\.\d{1,2})?$/]|greater_than[0]',
            'langue' => 'required|string|min_length[2]|max_length [50]',
        ];
        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('error', 'Données invalides.');
        }
    
        $data = [
            'titre'  => $this->request->getPost('titre'),
            'description' => $this->request->getPost('description'),
            'duree' => $this->request->getPost('duree'),
            'prix' => $this->request->getPost('prix'),
            'langue' => $this->request->getPost('langue'),
        ];

        $formationModel = new FormationModel();
        $formationModel->insert($data);


        return redirect()->to('/admin/formation/index');
    }
    /**
     * Récupère les données du formulaire de mise à jour d'une formation et
     * met à jour la formation correspondante dans la base de données
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function updateFormation() :\CodeIgniter\HTTP\RedirectResponse {
        $rules = [
            'titre' => 'required|string|min_length[2]|max_length[300]',
            'description' => 'required|string|min_length[2]|max_length[2500]',
            'duree' => 'required|string|min_length[2]|max_length[150]',
            'prix' => 'required|regex_match[/^\d+(\.\d{1,2})?$/]|greater_than[0]',
            'langue' => 'required|string|min_length[2]|max_length [50]',
        ];
        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('error', 'Données invalides.');
        }
    
        $data = [
            'titre'  => $this->request->getPost('titre'),
            'description' => $this->request->getPost('description'),
            'duree' => $this->request->getPost('duree'),
            'prix' => $this->request->getPost('prix'),
            'langue' => $this->request->getPost('langue'),
        ];

        $formationModel = new FormationModel();
        $formationModel->update($data, ['id' => $this->request->getPost('id')]);

        return redirect()->to('/admin/formation/index');
    }
    /**
     * Récupère l'identifiant de la formation à supprimer et
     * supprime la formation correspondante de la base de données
     * 
     * Côté JS la vue lui demande confirmation avant de faire la requete de suppression
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function deleteFormation() :\CodeIgniter\HTTP\RedirectResponse {
        $formationModel = new FormationModel();
        $formationModel->delete($this->request->getPost('id'));

        return redirect()->to('/admin/formation/index');
    }
    /**
     * Récupère l'identifiant de la formation dont on veut gérer les sessions et
     * redirige vers le panel de gestion des sessions de cette formation
     *
     * @param int $id_formation L'identifiant de la formation dont on veut gérer les sessions
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function manageSessions($id_formation) :\CodeIgniter\HTTP\RedirectResponse {
        return redirect()->to("/admin/session/index/$id_formation");
    }
}