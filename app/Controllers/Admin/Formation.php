<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FormationModel;
use App\Models\TypeFormationModel;

class Formation extends BaseController {
    /**
     * Affiche l'interface de gestion des formations, 
     * avec la liste des formations existantes et 
     * les options de I/U/D pour chaque formation
     *
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    function index() {
        $formationModel     = new FormationModel();
        $typeFormationModel = new TypeFormationModel();

        $formations = $formationModel->getAllWithTypes();
        $types      = $typeFormationModel->findAll();

        if ($this->request->isAJAX()) {
            return view('admin/formation/index', [
                'formations' => $formations,
                'types'      => $types,
            ]);
        }

        return redirect()->to('/admin/dashboard');
    }
    /**
     * Récupère les données du formulaire de création d'une formation et
     * crée une nouvelle formation dans la base de données avec ces données
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    function createFormation() {
        $data = $this->request->getJSON(true);

        $formationModel = new FormationModel();
        $id = $formationModel->insert([
            'titre'       => $data['titre'],
            'DESCRIPTION' => $data['description'],
            'duree'       => !empty($data['duree'])  ? $data['duree']  : null,
            'prix'        => !empty($data['prix'])   ? $data['prix']   : null,
            'langue'      => !empty($data['langue']) ? $data['langue'] : null,
        ]);

        if (!empty($data['types'])) {
            $formationModel->syncTypes($id, $data['types']);
        }

        return $this->response->setJSON(['success' => true]);
    }
    /**
     * Récupère les données du formulaire de mise à jour d'une formation et
     * met à jour la formation correspondante dans la base de données
     * Resynchronise également les types associés
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    function updateFormation() {
        $data = $this->request->getJSON(true);

        $formationModel = new FormationModel();
        $formationModel->update($data['id_formation'], [
            'titre'       => $data['titre'],
            'DESCRIPTION' => $data['description'],
            'duree'       => !empty($data['duree'])  ? $data['duree']  : null,
            'prix'        => !empty($data['prix'])   ? $data['prix']   : null,
            'langue'      => !empty($data['langue']) ? $data['langue'] : null,
        ]);

        $formationModel->syncTypes($data['id_formation'], $data['types'] ?? []);

        return $this->response->setJSON(['success' => true]);
    }
    /**
     * Supprime (soft delete) une formation spécifique de la base de données
     *
     * Côté JS la vue lui demande confirmation avant de faire la requete de suppression
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    function deleteFormation() {
        $data = $this->request->getJSON(true);

        $formationModel = new FormationModel();
        $formationModel->delete($data['id_formation']);

        return $this->response->setJSON(['success' => true]);
    }
    /**
     * Affiche la liste des formations ayant une date non null dans deleted_at
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    function getDeleted() {
        $formationModel = new FormationModel();
        $formations = $formationModel->onlyDeleted()->findAll();
        return $this->response->setJSON(['success' => true, 'data' => $formations]);
    }
    /**
     * Restaure une formation supprimée en mettant deleted_at à null
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    function restoreFormation() {
        $data = $this->request->getJSON(true);
        $formationModel = new FormationModel();
        $formationModel->restore($data['id_formation']);
        return $this->response->setJSON(['success' => true]);
    }
    /**
     * Retourne les types associés à une formation donnée
     *
     * @param int $id L'identifiant de la formation
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    function getTypes(int $id) {
        $formationModel = new FormationModel();
        $types = $formationModel->getTypes($id);
        return $this->response->setJSON(['success' => true, 'data' => $types]);
    }
}