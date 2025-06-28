<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

Route::get('/check-auth-provider', function () {
    try {
        $user = auth('api')->user();
        return [
            'using_api_guard' => true,
            'authenticated' => auth('api')->check(),
            'user' => $user
        ];
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
});