<?php

namespace App\Services\User;

class RegisterDTO
{
    public string $email;
    public string $name;
    public string $plainPassword;

    public function __construct(string $email, string $name, string $plainPassword)
    {
        $this->email = $email;
        $this->name = $name;
        $this->plainPassword = $plainPassword;
    }
}
