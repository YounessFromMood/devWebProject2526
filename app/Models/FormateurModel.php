<?php

namespace App\Models;

class FormateurModel extends UserModel {
    protected $table = 'formateur';
    protected $primaryKey = 'id_formateur';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'prenom', 'email', 'mdp', 'num_tel'];
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';

    /**
    * Restaure un formateur supprimé en mettant deleted_at à null
    *
    * @param int $id
    * @return void
    */
    public function restore(int $id) : void {
        $this->db->table('formateur')
            ->where('id_formateur', $id)
            ->update(['deleted_at' => null]);
    }
}