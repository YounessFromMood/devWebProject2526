<?php 

namespace App\Controllers;

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
        return view('formation_index', $data);
    }

    function search() :void {
        //return view('');
    }

    function details() :void {
        //return view('');
    }
}