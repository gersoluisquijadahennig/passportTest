<?php

namespace App\Entities;

use App\Models\User;
use OpenIDConnect\Claims\Traits\WithClaims;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use OpenIDConnect\Interfaces\IdentityEntityInterface;

class IdentityEntity implements IdentityEntityInterface
{
    use EntityTrait;
    use WithClaims;

    /**
     * El usuario del cual recopilar la información adicional
     */
    protected User $user;

    /**
     * El repositorio de identidad crea esta entidad y proporciona el id del usuario
     * @param mixed $identifier
     */
    public function setIdentifier($identifier): void
    {
        $this->identifier = $identifier;
        $this->user = User::findOrFail($identifier);
    }

    /**
     * Al construir el id_token, se recopilan los claims de esta entidad
     */
    public function getClaims(array $scopes = []): array
    {
        return [
            'email' => $this->user->correo_electronico,
        ];
    }
}