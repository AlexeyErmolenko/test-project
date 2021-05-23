<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Auth service.
 */
class AuthService extends BaseServiceWithValidation
{
    /**
     * Login app and get token.
     *
     * @param LoginRequest $request Login http request
     *
     * @return string
     *
     * @throws ValidationException
     * @throws HttpException
     */
    public function login(LoginRequest $request): string
    {
        $this->validate($request->all(), $this->getLoginRules());
        
        $token = auth()->attempt($request->all());
        
        if (!$token) {
            throw new HttpException(401, 'Unauthorized.');
        }
        
        return $token;
    }
    
    /**
     * Signed out from app.
     *
     * @return void
     */
    public function logout(): void
    {
        auth()->logout();
    }
    
    /**
     * Refresh aut token.
     *
     * @return string
     */
    public function refresh(): string
    {
        return auth()->refresh();
    }
    
    /**
     * Get login rules for validation.
     *
     * @return string[]
     */
    protected function getLoginRules(): array
    {
        return [
            LoginRequest::EMAIL => [
                'required',
                'string',
                'min:3',
                'max:100',
                'email',
                Rule::exists(User::TABLE_NAME, User::EMAIL),
            ],
            LoginRequest::PASSWORD => ['required', 'string', 'min:5', 'max:30'],
        ];
    }
}
