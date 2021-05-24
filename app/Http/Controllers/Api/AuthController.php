<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Controller for working with user authorization.
 */
class AuthController extends Controller
{
    /**
     * Auth service.
     *
     * @var AuthService
     */
    protected $authService;
    
    /**
     * Controller for working with user authorization.
     *
     * @param AuthService $authService Auth service
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    
    /**
     * Login app.
     *
     * @param LoginRequest $request Login http request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->authService->login($request);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors(), $exception->getCode());
        } catch (HttpException $exception) {
            return response()->json($exception->getMessage(), $exception->getCode());
        }
        
        return $this->sendToken($token);
    }
    
    /**
     * Signed out from app.
     *
     * @return Response
     */
    public function logout(): Response
    {
        $this->authService->logout();
        
        return response()->noContent();
    }
    
    /**
     * Refresh auth token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->sendToken($this->authService->refresh());
    }
    
    /**
     * Send response with auth token.
     *
     * @param string $token Auth token
     *
     * @return JsonResponse
     */
    protected function sendToken(string $token): JsonResponse
    {
        return response()->json(['token' => $token]);
    }
}
