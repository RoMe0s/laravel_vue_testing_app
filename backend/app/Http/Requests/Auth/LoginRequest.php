<?php

namespace App\Http\Requests\Auth;

use App\Services\User\AuthenticateDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $email
 * @property-read string $password
 */
class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false === auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function getDTO(): AuthenticateDTO
    {
        return new AuthenticateDTO($this->email, $this->password);
    }
}
