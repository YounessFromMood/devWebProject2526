<?php

namespace App\Controllers;

use App\Models\FormationModel;
use App\Models\TypeFormationModel;
use App\Models\TyperModel;
use App\Models\SessionModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Formation extends BaseController
{
    public function index(): string
    {
        $typeModel = new TypeFormationModel();

        $data = [
            'pageTitle' => 'Rechercher une formation',
            'types'     => $typeModel->findAll(),
        ];

        return view('formation/index', $data);
    }

    public function search()
    {
        $rules = [
            'titre'    => 'permit_empty|string|max_length[200]',
            'prix_max' => 'permit_empty|numeric',
            'types'    => 'permit_empty',
            'types.*'  => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([]);
        }

        $formationModel = new FormationModel();

        $filtres = [
            'titre'             => $this->request->getGet('titre'),
            'prix_max'          => $this->request->getGet('prix_max'),
            'id_type_formation' => $this->request->getGet('types'),
        ];

        $resultats = $formationModel->search($filtres);

        $formations = [];

        foreach ($resultats as $ligne) {
            $id = $ligne['id_formation'];

            if (!isset($formations[$id])) {
                $formations[$id] = $ligne;
                $formations[$id]['types'] = [];
                unset($formations[$id]['type_libelle']);
            }

            if (!empty($ligne['type_libelle']) && !in_array($ligne['type_libelle'], $formations[$id]['types'], true)) {
                $formations[$id]['types'][] = $ligne['type_libelle'];
            }
        }

        return $this->response->setJSON(array_values($formations));
    }

    public function details(int $id): string
    {
        $formationModel = new FormationModel();
        $formation = $formationModel->find($id);

        if ($formation === null) {
            throw new PageNotFoundException('Formation non trouvée.');
        }

        $typerModel = new TyperModel();
        $types = $typerModel->getTypesByFormation($id);

        $sessionModel = new SessionModel();
        $sessions = $sessionModel->getSessionsDisponibles($id);

        $dejainscrit = [];
        if (session()->get('role') === 'eleve') {
            $inscriptionModel = new \App\Models\InscriptionModel();
            $dejainscrit = $inscriptionModel->getIdSessionsByEleve(session()->get('user_id'));
        }

        foreach ($sessions as &$session) {
            $nbInscrits = $sessionModel->countInscrits($session['id_session']);
            $session['places_restantes'] = $session['nb_etudiant_max'] - $nbInscrits;
            $session['deja_inscrit'] = in_array($session['id_session'], $dejainscrit);
        }

        $data = [
            'pageTitle' => $formation['titre'],
            'formation' => $formation,
            'types'     => array_column($types, 'libelle'),
            'sessions'  => $sessions,
        ];

        return view('formation/details', $data);
    }
}