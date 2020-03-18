<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private const DEFAULT_DEVICE_NAME = 'api';

    public function authenticate(AuthenticateDTO $authenticateDTO): AuthenticatedUserDTO
    {
        /** @var User $user */
        $user = User::where('email', $authenticateDTO->email)->first();

        if (is_null($user) || false === Hash::check($authenticateDTO->plainPassword, $user->password)) {
            throw new WrongCredentialsException();
        }

        $accessToken = $user->createToken(self::DEFAULT_DEVICE_NAME);

        return new AuthenticatedUserDTO($user, $accessToken->plainTextToken);
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
