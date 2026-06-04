<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EleveModel;

class Student extends BaseController{

    function index() {
    $eleveModel = new EleveModel();
    $students = $eleveModel->findAll();

    if ($this->request->isAJAX()) {
        return view('admin/student/index', ['students' => $students]);
    }

    return redirect()->to('/admin/dashboard');
}
    /**
     * Récupère les données du formulaire de création d'un élève et
     * crée un nouvel élève dans la base de données avec ces données
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function createStudent() :\CodeIgniter\HTTP\RedirectResponse {
        $rules = [
            'nom' => 'required|string|min_length[2]|max_length[50]',
            'prenom' => 'required|string|min_length[2]|max_length[50]',
            'email' => 'required|valid_email|is_unique[eleve.email]',
            'mdp' => 'required|string|min_length[6]|max_length[255]',
        ];
        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('error', 'Données invalides.');
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'email' => $this->request->getPost('email'),
            'mdp' => password_hash($this->request->getPost('mdp'), PASSWORD_DEFAULT),
        ];
        $eleveModel = new EleveModel();
        $eleveModel->insert($data);

        return redirect()->to('/admin/student/index');
    }
    /**
     * Récupère les données du formulaire de mise à jour d'un élève et
     * met à jour l'élève correspondant dans la base de données
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function updateStudent() :\CodeIgniter\HTTP\RedirectResponse {
        $rules = [
            'nom' => 'required|string|min_length[2]|max_length[50]',
            'prenom' => 'required|string|min_length[2]|max_length[50]',
            'email' => 'required|valid_email|is_unique[eleve.email,id_eleve,{id_eleve}]',
            'mdp' => 'permit_empty|string|min_length[6]|max_length[255]',
        ];
        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('error', 'Données invalides.');
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'email' => $this->request->getPost('email'),
        ];
        if($this->request->getPost('mdp')){
            $data['mdp'] = password_hash($this->request->getPost('mdp'), PASSWORD_DEFAULT);
        }

        $eleveModel = new EleveModel();
        $eleveModel->update($this->request->getPost('id_eleve'), $data);
        
        return redirect()->to('/admin/student/index');
    }
    /**
     * Supprime un élève spécifique de la base de données
     * 
     * Côté JS la vue lui demande confirmation avant de faire la requete de suppression
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function deleteStudent() :\CodeIgniter\HTTP\RedirectResponse {
        $eleveModel = new EleveModel();
        $eleveModel->delete($this->request->getPost('id_eleve'));

        return redirect()->to('/admin/student/index');
    }
}