<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function test_me_should_throw_unauthorized_exception_when_no_user_is_signed_in()
    {
        $response = $this->getJson('/api/user');

        $response->assertUnauthorized();
    }

    public function test_me_should_return_user_data_when_user_is_signed_in()
    {
        $user = $this->signIn();
        $response = $this->getJson('/api/user');

        $response->assertJsonFragment([
            'email' => $user->email,
            'name' => $user->name,
        ]);
    }
}
