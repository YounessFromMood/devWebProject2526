<?php 

namespace App\Controllers;

use App\Models\FormationModel;
use App\Models\TypeFormationModel;

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
    /**
     * Une fonction de recherche selon des critères prédisposé à l'utilisateur
     * Le titre, La langue, Le prix maximum, La durée et le type de formation (Cybersec, Programmation, etc)
     *
     * @return string la liste de toutes les formations correspondants aux critères exigés
     */
    function search() :string {
        $rules = [
            'titre' => 'permit_empty|string|max_length[200]',
            'langue' => 'permit_empty|string|max_length[50]',
            'prix_max' => 'permit_empty|numeric',
            'duree' => 'permit_empty|string|max_length[50]',
            'id_type_formation' => 'permit_empty|integer',
        ];
        /*garde-fou si les données encodées ne respecte pas les
         règles pré-citées*/
        if (!$this->validate($rules)) {
            return $this->index();
        }
        //On recup ce qu'on envoie avec le get
        $filtres = [
            $titre    = $this->request->getGet('titre');
            $langue   = $this->request->getGet('langue');
            $prixMax  = $this->request->getGet('prix_max');
            $duree    = $this->request->getGet('duree');
            //faire jointure 
            $idType   = $this->request->getGet('id_type_formation');
        ];

        $formationModel = new FormationModel();
        $typeModel = new TypeFormationModel();

        $data['listeFormation'] = $formationModel->search($filtres);
        $data['types']          = $typeModel->findAll();

        return view('formation/index', $data);
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