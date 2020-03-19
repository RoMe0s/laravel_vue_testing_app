<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class FeatureTestCase extends TestCase
{
    public function signIn(array $userOverrides = []): User
    {
        $user = factory(User::class)->create($userOverrides);
        $this->actingAs($user);

        return $user;
    }
}
