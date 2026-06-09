<?php

namespace App\Filters;

use App\Models\EleveModel;
use App\Models\FormateurModel;
use App\Models\AdminModel;
use App\Models\RememberTokenModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

helper('cookie');

class RememberMeFilter implements FilterInterface
{
    /**
     * Vérifie avant chaque requête si un cookie "remember_token" existe.
     * Si oui et que la session est vide, on reconnecte automatiquement l'utilisateur.
     */
    public function before(RequestInterface $request, $arguments = null) {
        if (session()->has('user_id')) {
            return;
        }

        $token = get_cookie('remember_token');

        if (!$token) {
            return;
        }

        $rememberModel = new RememberTokenModel();
        $row = $rememberModel->findValidToken($token);

        if (!$row) {
            delete_cookie('remember_token');
            return;
        }

        $user = $this->findUserById($row['user_id'], $row['user_type']);

        if (!$user) {
            $rememberModel->deleteForUser($row['user_id'], $row['user_type']);
            delete_cookie('remember_token');
            return;
        }

        $role = $row['user_type'] === 'administrateur' ? 'admin' : $row['user_type'];

        session()->set([
            'user_id' => $row['user_id'],
            'role'    => $role,
            'nom'     => $user['nom'],
            'prenom'  => $user['prenom'],
            'email'   => $user['email'],
        ]);

        $redirects = [
            'eleve'     => '/student/dashboard',
            'formateur' => '/teacher/dashboard',
            'admin'     => '/admin/dashboard',
        ];

        return redirect()->to($redirects[$role]);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        
    }

    /**
     * Retrouve un utilisateur par son id et son type dans la bonne table
     */
    private function findUserById(int $userId, string $userType): ?array {
        $models = [
            'eleve'          => new EleveModel(),
            'formateur'      => new FormateurModel(),
            'administrateur' => new AdminModel(),
        ];

        $model = $models[$userType] ?? null;
        if (!$model) {
            return null;
        }

        return $model->find($userId) ?: null;
    }
}