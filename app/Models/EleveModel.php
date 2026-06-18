<?php

namespace App\Models;

class EleveModel extends UserModel {
    protected $table = 'eleve';
    protected $primaryKey = 'id_eleve';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'prenom', 'email', 'mdp', 'num_tel', 'photo_profil'];
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';

    /**
     * Restaure un élève supprimé en mettant deleted_at à null
     *
     * @param int $id
     * @return void
     */
    public function restore(int $id) : void {
        $this->db->table('eleve')
            ->where('id_eleve', $id)
            ->update(['deleted_at' => null]);
    }
}


