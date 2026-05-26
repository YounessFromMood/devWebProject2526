<?php 

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\InscriptionModel;

class Payment extends BaseController {
     private int $studentId;
    /**
     * Quand le controlleur est appelé, 
     * avant toute action elle initialise le user_id
     */
    public function initController(RequestInterface $request,
                                    ResponseInterface $response,
                                    LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->studentId = session()->get('user_id');
    }

    function paymentPage() :string {
        return view('student/payment');
    }
    /**
     * Lorsque l'étudiant confirme avoir envoyé le paiement, l'admin verra une ligne dans sa liste en attente de validation du paiement.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse redirige vers le dashboard de l'élève avec un message de succès
     */
    function confirmPayment() :\CodeIgniter\HTTP\RedirectResponse {
        $inscriptionModel = new InscriptionModel();
        $isSessionConfirmed = $inscriptionModel->confirmPayment($this->studentId,
                                                                $this->request->getPost('id_session'));

        if(!$isSessionConfirmed) {
            return redirect()->to('/student/dashboard')->with('error', "Une erreur est survenue lors de la confirmation de votre paiement.");
        }
        return redirect()->to('/student/dashboard')->with('success', "En attente de confirmation de votre paiement.");
    }
}