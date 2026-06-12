<?php

namespace App\Models;

use App\Models\UserModel;

class FormationModel extends UserModel {

    protected $table         = 'formation';
    protected $primaryKey    = 'id_formation';
    protected $returnType    = 'array';
    protected $allowedFields = ['titre', 'description', 'duree', 'prix', 'langue'];
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';

    /**
     * Retourne toutes les formations avec leurs types concaténés
     *
     * @return array
     */
    public function getAllWithTypes() : array {
        return $this
            ->select('formation.*, GROUP_CONCAT(type_formation.libelle SEPARATOR ", ") AS types')
            ->join('Typer', 'Typer.id_formation = formation.id_formation', 'left')
            ->join('type_formation', 'type_formation.id_type_formation = Typer.id_type_formation', 'left')
            ->groupBy('formation.id_formation')
            ->findAll();
    }

    /**
     * Retourne les types associés à une formation donnée
     *
     * @param int $id
     * @return array
     */
    public function getTypes(int $id) : array {
        return $this->db->table('Typer')
            ->where('id_formation', $id)
            ->get()->getResultArray();
    }

    /**
     * Synchronise les types d'une formation (supprime les anciens, insère les nouveaux)
     *
     * @param int   $id_formation
     * @param array $types
     * @return void
     */
    public function syncTypes(int $id_formation, array $types) : void {
        $this->db->table('Typer')->where('id_formation', $id_formation)->delete();
        foreach ($types as $idType) {
            $this->db->table('Typer')->insert([
                'id_formation'      => $id_formation,
                'id_type_formation' => $idType,
            ]);
        }
    }

    public function search(array $filtres) : array {
        $builder = $this->db->table('formation');
        $builder->join('Typer', 'Typer.id_formation = formation.id_formation', 'left')
                ->join('type_formation', 'type_formation.id_type_formation = Typer.id_type_formation', 'left')
                ->select('formation.*, type_formation.libelle AS type_libelle')
                ->where('formation.deleted_at', null);

        if (!empty($filtres['titre'])) {
            $builder->like('formation.titre', $filtres['titre']);
        }
        if (!empty($filtres['langue'])) {
            $builder->where('formation.langue', $filtres['langue']);
        }
        if (!empty($filtres['prix_max'])) {
            $builder->where('formation.prix <=', $filtres['prix_max']);
        }
        if (!empty($filtres['duree'])) {
            $builder->where('formation.duree', $filtres['duree']);
        }
        if (!empty($filtres['id_type_formation'])) {
            $builder->whereIn('Typer.id_type_formation', $filtres['id_type_formation']);
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Restaure une formation supprimée en mettant deleted_at à null
     *
     * @param int $id
     * @return void
     */
    public function restore(int $id) : void {
        $this->db->table('formation')
            ->where('id_formation', $id)
            ->update(['deleted_at' => null]);
    }
}