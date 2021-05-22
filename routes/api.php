<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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
    
    Route::middleware('api.auth')->group(function() {
        Route::put('auth', [AuthController::class, 'refresh']);
        Route::delete('auth', [AuthController::class, 'logout']);
    });
});
