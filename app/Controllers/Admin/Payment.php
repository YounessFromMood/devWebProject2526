<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InscriptionModel;
use CodeIgniter\HTTP\ResponseInterface;

class Payment extends BaseController
{
    /**
     * Affiche la liste des paiements en attente de confirmation,
     * c'est-à-dire les inscriptions où l'élève a signalé avoir payé
     * mais où l'administrateur n'a pas encore confirmé la réception
     *
     * @return string
     */
    public function index(): string
    {
        $inscriptionModel = new InscriptionModel();
        $pendingPayments  = $inscriptionModel->getPendingPayments();

        return view('admin/payment', ['pendingPayments' => $pendingPayments, 'pageTitle' => 'Gestion des paiements']);
    }

    /**
     * Confirme la réception du paiement d'un élève pour une session donnée
     * en passant paiement_recu à true dans la table S_inscrire
     *
     * @return ResponseInterface
     */
    public function confirmPayment(): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        if (empty($data['id_eleve']) || empty($data['id_session'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Données manquantes.',
            ]);
        }

        $inscriptionModel = new InscriptionModel();
        $success = $inscriptionModel->confirmPayment(
            (int) $data['id_eleve'],
            (int) $data['id_session']
        );

        return $this->response->setJSON(['success' => $success]);
    }
}