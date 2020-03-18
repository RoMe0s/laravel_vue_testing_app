<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\User\UserService;
use App\Services\User\WrongCredentialsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    public function login(LoginRequest $request, UserService $userService): JsonResponse
    {
        try {
            $authenticatedUser = $userService->authenticate($request->getDTO());
        } catch (WrongCredentialsException $exception) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        } catch (\Throwable $throwable) {
            throw $throwable;
        }

        return new JsonResponse(['token' => $authenticatedUser->token]);
    }

    public function register(RegisterRequest $request, UserService $userService): JsonResponse
    {
        $userService->register($request->getDTO());
        return new JsonResponse();
    }
}
