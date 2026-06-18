<?php

namespace App\Controllers;

class Legal extends BaseController
{
    public function conditions()
    {
        return view('legal/conditions', ['pageTitle' => "Conditions d'utilisation"]);
    }

    public function confidentialite()
    {
        return view('legal/confidentialite', ['pageTitle' => 'Politique de confidentialité']);
    }
}