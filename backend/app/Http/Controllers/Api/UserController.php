<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    public function me(Request $request): array
    {
        return UserResource::make($request->user())->toArray($request);
    }
}
