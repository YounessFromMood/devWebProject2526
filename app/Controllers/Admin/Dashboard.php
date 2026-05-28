<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
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
class Dashboard extends BaseController {

    private int $adminId;
    /**
     * Quand le controlleur est appelé, 
     * avant toute action elle initialise le user_id
     */
    public function initController(RequestInterface $request,
                                    ResponseInterface $response,
                                    LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->adminId = session()->get('user_id');
    }
    /**
     * Point d'entrée pour le dashboard de l'administrateur
     *
     * @return string La vue du dashboard administrateur
     */
    function index() :string {

        $data = [
            'nom' => session()->get('nom'),
            'prenom' => session()->get('prenom'),
            'email' => session()->get('email'),
        ];
        return view('admin/dashboard', $data);
    }
    /**
     * Lorsque l'administrateur souhaite I/U/D un étudiant, 
     * il est redirigé vers le panel de gestion des étudiants
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function goToStudentsPanel() :\CodeIgniter\HTTP\RedirectResponse {

        return redirect()->to('/admin/student/index');
    }
    /**
     * Lorsque l'administrateur souhaite I/U/D un formateur, 
     * il est redirigé vers le panel de gestion des formateurs
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function goToTeachersPanel() :\CodeIgniter\HTTP\RedirectResponse {
        return redirect()->to('/admin/teacher/index');
    }
    /**
     * Lorsque l'administrateur souhaite I/U/D une formation, 
     * il est redirigé vers le panel de gestion des formations
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function goToFormationsPanel() :\CodeIgniter\HTTP\RedirectResponse {
        return redirect()->to('/admin/formation/index');
    }
    /**
     * Lorsque l'administrateur souhaite check les paiements 
     * et valider une inscription, il est redirigé vers le panel de gestion des paiements
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function goToPaymentsPanel() :\CodeIgniter\HTTP\RedirectResponse {
        return redirect()->to('/admin/payment');
    }
}