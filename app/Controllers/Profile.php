<?php

namespace App\Controllers;

use App\Models\EleveModel;
use App\Models\FormateurModel;
use App\Models\AdminModel;

class Profile extends BaseController
{
    // Aiguillage selon le role connecté
    private function contexte(): ?array
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        $map = [
            'eleve'     => ['model' => new EleveModel(),     'idField' => 'id_eleve',          'table' => 'eleve'],
            'formateur' => ['model' => new FormateurModel(), 'idField' => 'id_formateur',      'table' => 'formateur'],
            'admin'     => ['model' => new AdminModel(),     'idField' => 'id_administrateur', 'table' => 'administrateur'],
        ];

        if (! isset($map[$role]) || empty($userId)) {
            return null;
        }

        $ctx            = $map[$role];
        $ctx['user_id'] = $userId;
        return $ctx;
    }

    public function updateInfo()
    {
        $ctx = $this->contexte();
        if ($ctx === null) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non connecte.']);
        }

        $regles = [
            'nom'    => 'required|max_length[50]',
            'prenom' => 'required|max_length[50]',
            'email'  => "required|valid_email|max_length[70]|is_unique[{$ctx['table']}.email,{$ctx['idField']},{$ctx['user_id']}]",
        ];

        // Mot de passe facultatif : valide/change seulement si saisi
        $mdp = (string) $this->request->getPost('mdp');
        if ($mdp !== '') {
            $regles['mdp'] = 'min_length[8]|max_length[72]';
        }

        if (! $this->validate($regles)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => implode(' ', $this->validator->getErrors()),
                'csrf'    => csrf_hash(),
            ]);
        }

        $donnees = [
            'nom'    => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'email'  => $this->request->getPost('email'),
        ];

        if ($mdp !== '') {
            $donnees['mdp'] = password_hash($mdp, PASSWORD_DEFAULT);
        }

        $ctx['model']->update($ctx['user_id'], $donnees);

        // On met a jour la session
        session()->set([
            'nom'    => $donnees['nom'],
            'prenom' => $donnees['prenom'],
            'email'  => $donnees['email'],
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Informations mises a jour.',
            'csrf'    => csrf_hash(),
        ]);
    }

    public function updatePhoto()
    {
        $ctx = $this->contexte();
        if ($ctx === null) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non connecte.']);
        }

        $regles = [
            'photo_profil' => [
                'rules'  => 'uploaded[photo_profil]|is_image[photo_profil]'
                          . '|mime_in[photo_profil,image/jpg,image/jpeg,image/png,image/webp]'
                          . '|max_size[photo_profil,2048]',
                'errors' => [
                    'uploaded' => 'Aucun fichier recu.',
                    'is_image' => 'Le fichier doit etre une image.',
                    'mime_in'  => 'Formats acceptes : JPG, PNG, WEBP.',
                    'max_size' => 'Image trop lourde (2 Mo maximum).',
                ],
            ],
        ];

        if (! $this->validate($regles)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => implode(' ', $this->validator->getErrors()),
                'csrf'    => csrf_hash(),
            ]);
        }

        $fichier = $this->request->getFile('photo_profil');

        if (! $fichier->isValid() || $fichier->hasMoved()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Fichier invalide.', 'csrf' => csrf_hash()]);
        }

        // On cree notre propre nom de fichier pour eviter des injections
        $nouveauNom = $ctx['table'] . '_' . $ctx['user_id'] . '_' . time() . '.' . $fichier->getExtension();

        $fichier->move(FCPATH . 'uploads/profiles', $nouveauNom);

        $cheminEnBase = 'uploads/profiles/' . $nouveauNom;
        $ctx['model']->update($ctx['user_id'], ['photo_profil' => $cheminEnBase]);

        // En session aussi, pour afficher tout de suite dans le dashboard
        session()->set(['photo_profil' => $cheminEnBase]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Photo mise a jour.',
            'url'     => base_url($cheminEnBase),
            'csrf'    => csrf_hash(),
        ]);
    }
}