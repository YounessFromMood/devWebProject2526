<?php 

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\InscriptionModel;
use App\Models\SessionModel;

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

    function paymentPage(int $idSession) :string {
        $sessionModel = new SessionModel();
        $session = $sessionModel->getSessionsDisponibles_byId($idSession);

        if ($session === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Session introuvable.');
        }

        $base = str_pad($this->studentId, 5, '0', STR_PAD_LEFT)
              . str_pad($idSession, 5, '0', STR_PAD_LEFT);

        $modulo = (int) $base % 97;
        $cle    = $modulo === 0 ? 97 : $modulo;

        $communication = '+++'
            . substr($base, 0, 3) . '/'
            . substr($base, 3, 4) . '/'
            . substr($base, 7, 3) . str_pad($cle, 2, '0', STR_PAD_LEFT)
            . '+++';

        $data = [
            'session'       => $session,
            'communication' => $communication,
        ];

        return view('student/payment', $data);
    }
    /**
     * Lorsque l'étudiant confirme avoir envoyé le paiement, l'admin verra une ligne dans sa liste en attente de validation du paiement.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse redirige vers le dashboard de l'élève avec un message de succès
     */
    function confirmPayment(int $idSession) :\CodeIgniter\HTTP\RedirectResponse {
        $inscriptionModel = new InscriptionModel();
        $isSessionConfirmed = $inscriptionModel->signalPayment($this->studentId, $idSession);

        if(!$isSessionConfirmed) {
            return redirect()->to('/student/dashboard')->with('error', "Une erreur est survenue lors de la confirmation de votre paiement.");
        }
        return redirect()->to('/student/dashboard')->with('success', "Paiement signalé ! En attente de confirmation de l'administration.");
    }
}