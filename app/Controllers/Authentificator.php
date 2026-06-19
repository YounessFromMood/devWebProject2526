<?php

namespace App\Controllers;

use App\Models\EleveModel;
use App\Models\FormateurModel;
use App\Models\AdminModel;
use App\Models\RememberTokenModel;

class Authentificator extends BaseController {

    /**
     * Retourne la vue adéquate pour que l'utilisateur puisse 
     * se connecter a son compte si existant
     */
    public function loginPage() :string {
        return view('login_page', ['pageTitle' => 'Connexion']);
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
        $mdp   = $this->request->getPost('mdp');
        $result = $this->findUserByEmail($email);
        $user   = $result['user'];

        // Un faux hash pour forcer un calcul même si l'user n'existe pas et se protéger d'un timing attack
        $hash = $user ? $user['mdp'] : '$2y$10$fakehashfakehashfakehashfakehashfakehashfakeha';

        if (!$user || !password_verify($mdp, $hash)) {
            return redirect()->back()->with('error', 'Email ou mot de passe incorrect.');
        }

        $role = $result['role'];

        $primaryKeys = [
            'eleve'      => 'id_eleve',
        'formateur'  => 'id_formateur',
            'admin'      => 'id_administrateur',
        ];

        $userId = $user[$primaryKeys[$role]];

         session()->set([
            'user_id'      => $userId,
            'role'         => $role,
            'nom'          => $user['nom'],
            'prenom'       => $user['prenom'],
            'email'        => $email,
            'photo_profil' => $user['photo_profil'] ?? null, 
        ]);

        if ($this->request->getPost('remember_me')) {
            $this->handleRememberMe($userId, $role);
        }

        $redirect = $this->request->getPost('redirect');

        if (!empty($redirect) && str_starts_with($redirect, '/') && !str_starts_with($redirect, '//')) {
            return redirect()->to(base_url($redirect));
        }

        return redirect()->to('/dashboard');
    }

    /**
     * Retourne la vue adéquate pour que l'utilisateur puisse
     * se créer un compte élève
     */
    public function registerPage() :string {
        return view('register_page', ['pageTitle' => 'Inscription']);
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
            'nom'         => 'required|string|min_length[2]|max_length[100]',
            'prenom'      => 'required|string|min_length[2]|max_length[100]',
            'email'       => 'required|valid_email|max_length[200]',
            'mdp'         => 'required|string|min_length[8]|max_length[72]',
            'num_tel'     => 'permit_empty|string|min_length[8]|max_length[20]',
            'mdp_confirm' => 'required|matches[mdp]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Données invalides.');
        }

        $email = $this->request->getPost('email');

        if ($this->emailAlreadyExists($email)) {
            return redirect()->back()->with('error', 'Cet email est déjà utilisé par un compte existant.');
        }

        $userModel = new EleveModel();
        $numTel    = $this->request->getPost('num_tel');

        $newStudentDatas = [
            'nom'     => $this->request->getPost('nom'),
            'prenom'  => $this->request->getPost('prenom'),
            'email'   => $email,
            'mdp'     => password_hash($this->request->getPost('mdp'), PASSWORD_DEFAULT),
            'num_tel' => ($numTel === '' || $numTel === null) ? null : $numTel,
        ];

        if (!$userModel->insert($newStudentDatas)) {
            return redirect()->back()->with('error', 'Une erreur est survenue, veuillez réessayer.');
        }

        return redirect()->to('/login')->with('success', 'Compte créé avec succès, vous pouvez vous connecter.');
    }

    /**
     * Détruit la session utilisateur en cours et redirige vers 
     * la page de connexion
     */
    public function logout() :\CodeIgniter\HTTP\RedirectResponse {
        $token = get_cookie('remember_token');
        if ($token) {
            $rememberModel = new RememberTokenModel();
            $row = $rememberModel->findValidToken($token);
            if ($row) {
                $rememberModel->deleteForUser($row['user_id'], $row['user_type']);
            }
            delete_cookie('remember_token');
        }

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
        foreach ($models as $model) {
            if ($model->where('email', $email)->first()) {
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
        foreach ($searches as $role => $model) {
            $user = $model->where('email', $email)->first();
            if ($user) {
                return ['user' => $user, 'role' => $role];
            }
        }
        return ['user' => null, 'role' => null];
    }

    /**
     * Génère un token aléatoire sécurisé, le sauvegarde en BDD
     * et pose le cookie sur le navigateur de l'utilisateur (valable 30 jours)
     */
    private function handleRememberMe(int $userId, string $role) : void {
        $rememberModel = new RememberTokenModel();
        $userType      = $role === 'admin' ? 'administrateur' : $role;

        if ($rememberModel->hasValidToken($userId, $userType)) {
            return; // Un token valide existe déjà, on ne recrée pas
        }

        $token = bin2hex(random_bytes(32));
        $rememberModel->saveToken($userId, $userType, $token);
        setcookie(
            'remember_token',
            $token,
            time() + (30 * 24 * 3600),
            '/',
            '',
            false,
            true
        );
    }
        /**
     * Affiche la page "mot de passe oublie"
     */
    public function forgotPasswordPage() :string {
        return view('forgot_password', ['pageTitle' => 'Mot de passe oublié']);
    }
 
    /**
     * Reinitialise directement le mot de passe
     * Identifie le compte par son email dans les 3 tables, puis enregistre
     * le nouveau mot de passe hache.
     */
    public function toResetPassword() :\CodeIgniter\HTTP\RedirectResponse {
        $rules = [
            'email'       => 'required|valid_email',
            'mdp'         => 'required|string|min_length[8]|max_length[72]',
            'mdp_confirm' => 'required|matches[mdp]',
        ];
 
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Donnees invalides.');
        }
 
        $email  = $this->request->getPost('email');
        $result = $this->findUserByEmail($email);
        $user   = $result['user'];
 
        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Aucun compte ne correspond a cet email.');
        }
 
        $role = $result['role'];
 
        $models = [
            'eleve'     => new EleveModel(),
            'formateur' => new FormateurModel(),
            'admin'     => new AdminModel(),
        ];
        $primaryKeys = [
            'eleve'     => 'id_eleve',
            'formateur' => 'id_formateur',
            'admin'     => 'id_administrateur',
        ];
 
        $userId = $user[$primaryKeys[$role]];
 
        $models[$role]->update($userId, [
            'mdp' => password_hash($this->request->getPost('mdp'), PASSWORD_DEFAULT),
        ]);
 
        // Par securite : on invalide les "remember me" existants de ce compte
        $rememberModel = new RememberTokenModel();
        $userType      = $role === 'admin' ? 'administrateur' : $role;
        $rememberModel->deleteForUser($userId, $userType);
 
        return redirect()->to('/login')->with('success', 'Mot de passe réinitialisé, vous pouvez vous connecter.');
    }
}