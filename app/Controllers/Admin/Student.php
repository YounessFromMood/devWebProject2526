<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EleveModel;

class Student extends BaseController {

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
    function createStudent() {
        $data = $this->request->getJSON(true);

        $eleveModel = new EleveModel();
        $eleveModel->insert([
            'nom'    => $data['nom'],
            'prenom' => $data['prenom'],
            'email'  => $data['email'],
            'mdp'    => password_hash($data['mdp'], PASSWORD_DEFAULT),
            'num_tel' => !empty($data['num_tel']) ? $data['num_tel'] : null,
        ]);

        return $this->response->setJSON(['success' => true]);
    }
    /**
     * Récupère les données du formulaire de mise à jour d'un élève et
     * met à jour l'élève correspondant dans la base de données
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function updateStudent() {
        $data = $this->request->getJSON(true);

        $update = [
            'nom'    => $data['nom'],
            'prenom' => $data['prenom'],
            'email'  => $data['email'],
            'num_tel' => !empty($data['num_tel']) ? $data['num_tel'] : null,
        ];

        if (!empty($data['mdp'])) {
            $update['mdp'] = password_hash($data['mdp'], PASSWORD_DEFAULT);
        }

        $eleveModel = new EleveModel();
        $eleveModel->update($data['id_eleve'], $update);

        return $this->response->setJSON(['success' => true]);
    }
    /**
     * Supprime un élève spécifique de la base de données
     * 
     * Côté JS la vue lui demande confirmation avant de faire la requete de suppression
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function deleteStudent() {
        $data = $this->request->getJSON(true);

        $eleveModel = new EleveModel();
        $eleveModel->delete($data['id_eleve']);

        return $this->response->setJSON(['success' => true]);
    }
    /**
     * Affiche la liste des étudiants ayant une date non null dans deleted_at
     */
    function getDeleted() {
        $eleveModel = new EleveModel();
        $students = $eleveModel->onlyDeleted()->findAll();
        return $this->response->setJSON(['success' => true, 'data' => $students]);
    }
    /**
     * Restaure un étudiant supprimé en mettant deleted_at à null
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function restoreStudent() {
        $data = $this->request->getJSON(true);
        $eleveModel = new EleveModel();
        $eleveModel->restore($data['id_eleve']);
        return $this->response->setJSON(['success' => true]);
    }
}