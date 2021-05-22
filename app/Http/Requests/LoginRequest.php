<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request for login.
 *
 * @property string $email User email
 * @property string $password User password
 */
class LoginRequest extends FormRequest
{
    public const EMAIL = 'email';
    public const PASSWORD = 'password';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            self::EMAIL => ['required', 'string'],
            self::PASSWORD => ['required', 'string'],
        ];
    }
}
