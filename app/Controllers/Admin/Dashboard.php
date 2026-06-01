<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


/**
* L'admin veut
* - Gérer les étudiants
* - Gérer les formateurs
* - Gérer les formations -> leur session
* - Check les notifications paiements et
*   les valider ou les refuser
*/
class Dashboard extends BaseController
{
    private int $adminId;

    /**
     * Quand le controlleur est appelé,
     * avant toute action elle initialise le user_id
     */
    public function initController(RequestInterface  $request,
                                   ResponseInterface $response,
                                   LoggerInterface   $logger)
    {
        parent::initController($request, $response, $logger);
        $this->adminId =(int) session()->get('user_id');
    }
    /**
     * Point d'entrée pour le dashboard de l'administrateur
     *
     * @return string La vue du dashboard administrateur
     */
    function index(): string|RedirectResponse
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }
        $data = [
            'nom' => session()->get('nom'),
            'prenom' => session()->get('prenom'),
            'email' => session()->get('email'),
        ];
        return view('admin/dashboard', $data);
    }
}
