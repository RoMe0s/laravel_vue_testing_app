<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    public function login(LoginRequest $request, UserService $userService): JsonResponse
    {
        $authenticatedUser = $userService->authenticate($request->getDTO());

        if (is_null($authenticatedUser)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        Auth::login($authenticatedUser);
        return new JsonResponse();
    }

    public function logout(): JsonResponse
    {
        Auth::logout();
        return new JsonResponse();
    }

    public function register(RegisterRequest $request, UserService $userService): JsonResponse
    {
        $userService->register($request->getDTO());
        return new JsonResponse();
    }
}
