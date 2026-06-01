<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FormateurModel;
use CodeIgniter\HTTP\RedirectResponse;

class Teacher extends BaseController{

    /**
     * Point d'entrée pour le panel de gestion des formateurs de l'administrateur
     *
     * @return string La vue du panel de gestion des formateurs
     */
    function index() :string {
        $teacherModel = new FormateurModel();
        $teachers = $teacherModel->findAll();

        return view('admin/teacher/index', ['teachers' => $teachers]);
        
    }
    /**
     * Récupère les données du formulaire de création d'un formateur et
     * crée un nouveau formateur dans la base de données avec ces données
     *
     * @return RedirectResponse
     */
    function createTeacher() : RedirectResponse {
        $rules = [
            'nom' => 'required|string|min_length[2]|max_length[50]',
            'prenom' => 'required|string|min_length[2]|max_length[50]',
            'email' => 'required|valid_email|is_unique[formateur.email]',
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
        $teacherModel = new FormateurModel();
        $teacherModel->insert($data);

        return redirect()->to('/admin/teacher/index');
 
    }
    /**
     * Récupère les données du formulaire de mise à jour d'un formateur et
     * met à jour le formateur correspondant dans la base de données
     *
     * @return RedirectResponse
     */
    function updateTeacher() : RedirectResponse {
        $rules = [
            'nom' => 'required|string|min_length[2]|max_length[50]',
            'prenom' => 'required|string|min_length[2]|max_length[50]',
            'email' => 'required|valid_email|is_unique[formateur.email,id_eleve,{id_eleve}]',
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
        $teacherModel = new FormateurModel();
        $teacherModel->update($this->request->getPost('id_teacher'), $data);

        return redirect()->to('/admin/teacher/index');
    }
    /**
     * Supprime un formateur spécifique de la base de données
     * 
     * Côté JS la vue lui demande confirmation avant de faire la requete de suppression
     *
     * @return RedirectResponse
     */
    function deleteTeacher() : RedirectResponse {
        $teacherModel = new FormateurModel();
        $teacherModel->delete($this->request->getPost('id_eleve'));

        return redirect()->to('/admin/teacher/index');
    }
}