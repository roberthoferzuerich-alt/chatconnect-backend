<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/me', [AuthController::class, 'me']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/profile', [\App\Http\Controllers\Api\ProfileController::class, 'update']);
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Api\UserController::class, 'index']);
        
        Route::get('/conversations', [\App\Http\Controllers\Api\ConversationController::class, 'index']);
        Route::post('/conversations', [\App\Http\Controllers\Api\ConversationController::class, 'store']);
        
        Route::get('/conversations/{conversation}/messages', [\App\Http\Controllers\Api\MessageController::class, 'index']);
        Route::post('/conversations/{conversation}/messages', [\App\Http\Controllers\Api\MessageController::class, 'store']);
        Route::post('/conversations/{conversation}/read', [\App\Http\Controllers\Api\MessageController::class, 'markAsRead']);
    });
});
