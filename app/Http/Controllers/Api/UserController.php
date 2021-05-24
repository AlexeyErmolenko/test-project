<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRegistrationRequest;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Throwable;

/**
 * Controller for working with user entities.
 */
class UserController extends Controller
{
    /**
     * User service.
     *
     * @var UserService
     */
    protected $service;
    
    /**
     * Controller for working with user entities.
     *
     * @param UserService $service User service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Registration new user in app.
     *
     * @param UserRegistrationRequest $request User registration request
     *
     * @return User
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function registration(UserRegistrationRequest $request): User
    {
        return $this->service->registration($request);
    }
    
    /**
     * Get auth user profile.
     *
     * @return User
     */
    public function getMeProfile(): User
    {
        return $this->service->getAuthUser();
    }
}
