<?php

namespace App\Controllers;

class History extends BaseController {

    function index() :\CodeIgniter\HTTP\RedirectResponse {
        $userRole = session()->get('user_role');

        switch($userRole) {
            case 'teacher':
                return redirect()->to('/teacher/history');
            case 'student':
                return redirect()->to('/student/history');
            default:
                return redirect()->to('/')->with('error', "Rôle utilisateur non reconnu.");
        } 
    }
}