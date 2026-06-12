<?php

namespace App\Controllers;

use App\Models\FormationModel;

class Home extends BaseController
{
    public function index(): string
    {
        $formationModel = new FormationModel();

        $formations = $formationModel->findAll();

        shuffle($formations);
        $randomToShow = array_slice($formations, 0, 4);

        $data = [
            'pageTitle'  => 'Accueil',
            'formations' => $randomToShow,
        ];

        return view('home', $data);
    }
}