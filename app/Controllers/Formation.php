<?php 

namespace App\Controllers;

use App\Models\FormationModel;

class Formation extends BaseController {
    /**
     * Retourne a la vue toutes les données de mes formations trié par id croissant
     *
     * @return string un tableau de formation contenant toutes les données de mes formations
     */
    function index() :string {
        //je crée une nouvelle instance de mon modèle
        $formationModel = new FormationModel();
        //je demande toutes les données de mon modèle
        $formations = $formationModel->findAll();
        /*Je stocke dans un tableau associatif tout les éléments
        trouvés dans ma bdd*/
        $data['listeFormation'] = $formations;
        //y'a plus qu'a tout régurgiter a la view
        return view('formation/index', $data);
    }

    function search() :void {
        //return view('');
    }

    function details(int $id) :string {
        $formationModel = new FormationModel();
        $formation = $formationModel->find($id);

        if($formation === null) {
            //TODO créer une exception

        }
        $data['formation'] = $formation;

        return view('formation/details', $data);
    }
}