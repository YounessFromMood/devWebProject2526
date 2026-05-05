<?php

namespace App\Models;

/**
 * Cette classe interne sert uniquement 
 * d'intermédiaire à mes controllers
 * pour inscrire un élève a une session
 */
class InscriptionModel extends UserModel{
    protected $table = 'S_inscrire';

    protected $returnType = 'string';

    protected $allowedFields = ['id_eleve, id_session, paiement_recu'];

    protected $useAutoIncrement = false;
}