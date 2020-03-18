<?php

namespace App\Http\Requests\Auth;

use App\Services\User\RegisterDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $email
 * @property-read string $name
 * @property-read string $password
 */
class RegisterRequest extends FormRequest
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
            'email' => 'required|email|max:255|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|max:24|confirmed',
        ];
    }

    public function getDTO(): RegisterDTO
    {
        return new RegisterDTO($this->email, $this->name, $this->password);
    }
}
