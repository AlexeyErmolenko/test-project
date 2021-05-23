<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix(config('api.version', 'v1'))->group(function () {
    Route::post('auth', [AuthController::class, 'login']);
    Route::post('users', [UserController::class, 'registration']);
    
    Route::middleware('api.auth')->group(function() {
        Route::put('auth', [AuthController::class, 'refresh']);
        Route::delete('auth', [AuthController::class, 'logout']);
        
        Route::get('users/me', [UserController::class, 'getMeProfile']);
    });
});
