<?php

namespace App\Controllers;

class History extends BaseController {

    function index() :\CodeIgniter\HTTP\RedirectResponse {
        $userRole = session()->get('role');

        switch($userRole) {
            case 'formateur':
                return redirect()->to('/teacher/history');
            case 'eleve':
                return redirect()->to('/student/history');
            default:
                return redirect()->to('/')->with('error', "Rôle utilisateur non reconnu.");
        } 
    }
}