<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function authenticate(AuthenticateDTO $authenticateDTO): ?User
    {
        /** @var User $user */
        $user = User::where('email', $authenticateDTO->email)->first();

        if ($user && Hash::check($authenticateDTO->plainPassword, $user->password)) {
            return $user;
        }
        return null;
    }

    public function register(RegisterDTO $registerDTO): User
    {
        return User::create([
            'email' => $registerDTO->email,
            'name' => $registerDTO->name,
            'password' => Hash::make($registerDTO->plainPassword),
        ]);
    }
}
