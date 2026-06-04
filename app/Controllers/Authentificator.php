<?php

namespace App\Controllers;

use App\Models\EleveModel;
use App\Models\FormateurModel;
use App\Models\AdminModel;

class Authentificator extends BaseController {

    /**
     * Retourne la vue adéquate pour que l'utilisateur puisse 
     * se connecter a son compte si existant
     */
    public function loginPage() :string {
        return view('login_page');
    }
    /**
     * Cette fonction s'occupe de vérifier si le user qui essaie
     * de se connecter existe bien dans la db.
     * 
     * SI:
     * n'est pas un élève -> formateur ? -> admin ?
     * -> Peut-être s'est il trompé dans l'entrée de ses logs
     * ->Message d'erreur et renvoie vers la login page
     * 
     * SINON tout a été vérifié:
     * Crée la session et redirige vers Dahsboard.php qui déterminera
     * quel Dashboard présenter selon le rôle
     */
    public function toLogIn() :\CodeIgniter\HTTP\RedirectResponse {
        
        $email = $this->request->getPost('email');
        $mdp = $this->request->getPost('mdp');

        $result = $this->findUserByEmail($email);
        $user = $result['user'];

        // Un faux hash pour forcer un calcul même si l'user n'existe pas et se protéger d'un timing attack
        $hash = $user ? $user['mdp'] : '$2y$10$fakehashfakehashfakehashfakehashfakehashfakeha';

        if(!$user || !password_verify($mdp, $hash)){
            return redirect()->back()->with('error', 'Email ou mot de passe incorrect.');
        }

        $role = $result['role'];
        
        $primaryKeys = [
            'eleve' => 'id_eleve',
            'formateur' => 'id_formateur',
            'admin' => 'id_administrateur',
        ];

        session()->set([
            'user_id' => $user[$primaryKeys[$role]],
            'role' => $role,
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'email' => $email,
        ]);

        return redirect()->to('/dashboard');
    }
    /**
     * Retourne la vue adéquate pour que l'utilisateur puisse
     * se créer un compte élève
     * 
     */
    public function registerPage() :string {
        return view('register_page');
    }
    /**
     * Cette fonction s'occupe de:
     * 1) Vérifier si les données entrées par l'utilisateur 
     * correspondent à mes restrictions bdd ou restrictions logique
     * 
     * 2) Vérifier si l'email entré par l'user n'existe pas déjà pour un
     * autre compte 
     */
    public function toRegister() :\CodeIgniter\HTTP\RedirectResponse {
        $rules = [
            'nom' => 'required|string|min_length[2]|max_length[100]',
            'prenom' => 'required|string|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[200]',
            'mdp' => 'required|string|min_length[8]|max_length[72]',
            'num_tel' => 'permit_empty|string|min_length[8]|max_length[20]',
            'mdp_confirm' => 'required|matches[mdp]',
        ];

        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('error', 'Données invalides.');
        }
        
        $email = $this->request->getPost('email');

        if($this->emailAlreadyExists($email)){
            return redirect()->back()->with('error', 'Cet email est déjà utilisé par un compte existant.');
        }
        
        $userModel = new EleveModel();

        $numTel = $this->request->getPost('num_tel');

        $newStudentDatas = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'email' => $email,
            'mdp' => password_hash($this->request->getPost('mdp'), PASSWORD_DEFAULT),
            'num_tel' => ($numTel === '' || $numTel === null) ? null : $numTel,
        ];

        if(!$userModel->insert($newStudentDatas)){
            return redirect()->back()->with('error', 'Une erreur est survenue, veuillez réessayer.');
        }

        return redirect()->to('/login')->with('success', 'Compte créé avec succès, vous pouvez vous connecter.');
    }
    /**
     * Détruit la session utilisateur en courset redirige vers 
     * la page de connexion
     */
    public function logout() :\CodeIgniter\HTTP\RedirectResponse {
        session()->destroy();
        return redirect()->to('/login');
    }
    /**
     * Check si un email existe dans les 3 tables utilisateurs
     * pour determiner si l'email entré n'est pas déjà existant 
     * lors d'une inscription
     */
    private function emailAlreadyExists(string $email) : bool {
        $models = [new EleveModel(), new FormateurModel(), new AdminModel()];
        foreach($models as $model){
            if($model->where('email', $email)->first()){
                return true;
            }
        }
        return false;
    }
    /**
     * Check si un email existe dans les 3 tables utilisateurs
     * et détermine son rôle a renvoyer pour Dashboard.php
     */
    private function findUserByEmail(string $email) : array {
        $searches = [
            'eleve'      => new EleveModel(),
            'formateur'  => new FormateurModel(),
            'admin'      => new AdminModel(),
        ];
        foreach($searches as $role => $model){
            $user = $model->where('email', $email)->first();
            if($user){
                return ['user' => $user, 'role' => $role];
            }
        }
        return ['user' => null, 'role' => null];
    }
}