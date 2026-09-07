<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\CallController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\MessageController;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/me', [AuthController::class, 'me']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/profile', ['App\\Http\\Controllers\\Api\\ProfileController', 'update']);
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users/sync-contacts', [UserController::class, 'syncContacts']);
        
        Route::get('/conversations', [ConversationController::class, 'index']);
        Route::post('/conversations', [ConversationController::class, 'store']);
        Route::post('/conversations/group', [ConversationController::class, 'storeGroup']);
        Route::delete('/conversations/{conversation}', [ConversationController::class, 'destroy']);
        
        Route::get('/calls', [CallController::class, 'index']);
        Route::post('/calls', [CallController::class, 'store']);
        
        // Stories
        Route::get('/stories', [StoryController::class, 'index']);
        Route::post('/stories', [StoryController::class, 'store']);
        
        Route::get('/conversations/{conversation}/messages', [MessageController::class, 'index']);
        Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store']);
        Route::post('/conversations/{conversation}/read', [MessageController::class, 'markAsRead']);
        Route::post('/messages/{message}/delete', [MessageController::class, 'destroy']);
    });
});
