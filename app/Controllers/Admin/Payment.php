<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use \App\Models\InscriptionModel;
use CodeIgniter\HTTP\RedirectResponse;

class Payment extends BaseController {
    /**
     * Point d'entrée pour le panel de gestion des paiements de l'administrateur
     *
     * @return string La vue du panel de gestion des paiements
     */
    function index() :string {
        $inscriptionsModel = new InscriptionModel();
        $data['payments'] = $inscriptionsModel->getPendingPayments();

        return view('admin/payment/index', $data); 
    }
    /**
     * Confirme un paiement en mettant à jour le statut de paiement dans la base de données
     *
     * @return RedirectResponse
     */
    function confirmPayment() : RedirectResponse {
        $studentId = $this->request->getPost('student_id');
        $sessionId = $this->request->getPost('session_id');

        if (!$studentId || !$sessionId) {
            return redirect()->to('/admin/payment')->with('error', 'Données manquantes.');
        }

        $inscriptionsModel = new InscriptionModel();
        $result = $inscriptionsModel->confirmPayment((int)$studentId, (int)$sessionId);

        if (!$result) {
            return redirect()->to('/admin/payment')->with('error', 'Une erreur est survenue.');
        }

        return redirect()->to('/admin/payment')->with('success', 'Paiement confirmé.');
    }
}