<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FormateurModel;

class Teacher extends BaseController {

    function index() {
        $formateurModel = new FormateurModel();
        $teachers = $formateurModel->findAll();

        if ($this->request->isAJAX()) {
            return view('admin/teacher/index', ['teachers' => $teachers, 'pageTitle' => 'Gestion des formateurs']);
        }

        return redirect()->to('/admin/dashboard');
    }
    /**
     * Récupère les données du formulaire de création d'un formateur et
     * crée un nouveau formateur dans la base de données avec ces données
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function createTeacher() {
        $data = $this->request->getJSON(true);

        $formateurModel = new FormateurModel();
        $formateurModel->insert([
            'nom'     => $data['nom'],
            'prenom'  => $data['prenom'],
            'email'   => $data['email'],
            'mdp'     => password_hash($data['mdp'], PASSWORD_DEFAULT),
            'num_tel' => !empty($data['num_tel']) ? $data['num_tel'] : null,
        ]);

        return $this->response->setJSON(['success' => true]);
    }
    /**
     * Récupère les données du formulaire de mise à jour d'un formateur et
     * met à jour le formateur correspondant dans la base de données
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function updateTeacher() {
        $data = $this->request->getJSON(true);

        $update = [
            'nom'     => $data['nom'],
            'prenom'  => $data['prenom'],
            'email'   => $data['email'],
            'num_tel' => !empty($data['num_tel']) ? $data['num_tel'] : null,
        ];

        $formateurModel = new FormateurModel();
        $formateurModel->update($data['id'], $update);

        return $this->response->setJSON(['success' => true]);
    }
    /**
     * Supprime un formateur spécifique de la base de données
     *
     * Côté JS la vue lui demande confirmation avant de faire la requete de suppression
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function deleteTeacher() {
        $data = $this->request->getJSON(true);

        $formateurModel = new FormateurModel();
        $formateurModel->delete($data['id']);

        return $this->response->setJSON(['success' => true]);
    }
    /**
     * Affiche la liste des formateurs ayant une date non null dans deleted_at
     *
     * @return
     */
    function getDeleted() {
        $formateurModel = new FormateurModel();
        $teachers = $formateurModel->onlyDeleted()->findAll();
        return $this->response->setJSON(['success' => true, 'data' => $teachers]);
    }
    /**
     * Restaure un formateur supprimé en mettant deleted_at à null
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function restoreTeacher() {
        $data = $this->request->getJSON(true);
        $formateurModel = new FormateurModel();
        $formateurModel->restore($data['id']);
        return $this->response->setJSON(['success' => true]);
    }
}