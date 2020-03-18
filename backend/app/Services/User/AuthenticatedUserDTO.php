<?php

namespace App\Services\User;

use App\Models\User;

class AuthenticatedUserDTO
{
    public User $user;
    public string $token;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }
}
