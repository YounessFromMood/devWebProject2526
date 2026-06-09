<?php

namespace App\Models;

use CodeIgniter\Model;

class RememberTokenModel extends Model
{
    protected $table         = 'remember_tokens';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['user_id', 'user_type', 'token', 'expires_at'];

    /**
     * Cherche un token valide (non expiré) dans la BDD.
     * Retourne la ligne trouvée, ou null si rien.
     */
    public function findValidToken(string $token): ?array
    {
        return $this
            ->where('token', $token)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->first();
    }
    /**
     * Insère un nouveau token en BDD avec une expiration à 30 jours.
     */
    public function saveToken(int $userId, string $userType, string $token): void
    {
        $this->insert([
            'user_id'    => $userId,
            'user_type'  => $userType,
            'token'      => $token,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
        ]);
    }
    /**
     * Supprime tous les tokens d'un utilisateur.
     * Utilisé quand il se déconnecte.
     */
    public function deleteForUser(int $userId, string $userType): void
    {
        $this->where('user_id', $userId)
             ->where('user_type', $userType)
             ->delete();
    }
    /**
     * Vérifie si un token valide existe déjà pour cet utilisateur
     */
    public function hasValidToken(int $userId, string $userType): bool
    {
        return $this
            ->where('user_id', $userId)
            ->where('user_type', $userType)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->first() !== null;
    }
    }