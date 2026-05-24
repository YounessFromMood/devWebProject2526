<?php

namespace App\Controllers;

class Dashboard extends BaseController {

    function redirector() :\CodeIgniter\HTTP\RedirectResponse {
        $userRole = session()->get('role');

        switch($userRole) {
            case 'eleve':
                return redirect()->to('/student/dashboard');   
            case 'formateur':
                return redirect()->to('/teacher/dashboard');
            case 'admin':
                return redirect()->to('/admin/dashboard');
            default:
                return redirect()->to('/')->with('error', 'Une erreur à été rencontrée. Veuillez réessayer ultérieurement.');  
        }
    }
}