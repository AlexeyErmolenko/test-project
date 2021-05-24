<?php

namespace App\Services;

use App\Events\UserRegisterEvent;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

/**
 * Service for working with user entities.
 */
class UserService extends BaseServiceWithValidation
{
    /**
     * Registration new user.
     *
     * @param UserRegistrationRequest $request User registration http request
     *
     * @return User
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function registration(UserRegistrationRequest $request): User
    {
        $this->validate($request->all(), $this->getRegisterRules());
        
        return $this->transaction(function () use ($request): User {
            $user = new User();
            
            $user->fill($request->all());
            $user->role = User::ROLE_USER;
            $user->password =  password_hash($request->password, PASSWORD_DEFAULT);
            $user->save();
            
            event(new UserRegisterEvent($user));
            
            return $user;
        });
    }
    
    /**
     * Get auth user.
     *
     * @return User
     */
    public function getAuthUser(): User
    {
        /* @var User $user */
        $user = Auth::user();
        
        return $user;
    }
    
    /**
     * Get rules for user registration.
     *
     * @return array
     */
    protected function getRegisterRules(): array
    {
        return [
            UserRegistrationRequest::FIRST_NAME => ['required', 'string', 'min:1', 'max:30'],
            UserRegistrationRequest::LAST_NAME => ['required', 'string', 'min:1', 'max:30'],
            UserRegistrationRequest::EMAIL => [
                'required',
                'string',
                'min:3',
                'max:100',
                'email',
                Rule::unique(User::TABLE_NAME, User::EMAIL),
            ],
            UserRegistrationRequest::PASSWORD => ['required', 'string', 'min:5', 'max:30'],
        ];
    }
}
