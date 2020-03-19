<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends FeatureTestCase
{
    use RefreshDatabase;

    // LOGIN

    public function test_login_should_throw_validation_exception_when_no_data_is_passed()
    {
        $response = $this->postJson('/api/login');

        $response->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_login_should_throw_validation_exception_when_wrong_data_is_passed()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'test@email.com',
            'password' => 'password',
        ]);

        $response->assertJsonValidationErrors(['email']);
    }

    public function test_login_should_return_ok_status_when_right_data_is_passed()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertOk();
    }

    public function test_login_should_redirect_when_user_is_already_signed_in()
    {
        $this->signIn();
        $response = $this->postJson('/api/login');

        $response->assertRedirect('/');
    }

    // LOGOUT

    public function test_logout_should_throw_unauthorized_exception_when_no_user_is_signed_in()
    {
        $response = $this->postJson('/api/logout');
        $response->assertUnauthorized();
    }

    public function test_logout_should_return_ok_status_when_user_is_signed_in()
    {
        $this->signIn();
        $response = $this->postJson('/api/logout');
        $response->assertOk();
    }

    // REGISTER

    public function test_register_should_throw_validation_exception_when_no_data_is_passed()
    {
        $response = $this->postJson('/api/register');

        $response->assertJsonValidationErrors(['email', 'name', 'password']);
    }

    public function test_register_should_throw_validation_exception_when_already_obtained_data_is_passed()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/api/register', [
            'email' => $user->email,
            'name' => $user->name,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertJsonValidationErrors(['email']);
    }

    public function test_register_should_return_ok_status_when_right_data_is_passed()
    {
        $response = $this->postJson('/api/register', [
            'email' => 'test@email.com',
            'name' => 'test name',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertOk();
    }

    public function test_register_should_redirect_when_user_is_already_signed_in()
    {
        $this->signIn();
        $response = $this->postJson('/api/register');

        $response->assertRedirect('/');
    }
}
