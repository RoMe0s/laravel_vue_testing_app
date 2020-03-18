<?php

namespace App\Services\User;

class AuthenticateDTO
{
    public string $email;
    public string $plainPassword;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->plainPassword = $password;
    }
}
