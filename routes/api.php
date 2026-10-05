<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\CallController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::prefix('v1')->group(function () {
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'message' => 'ChatConnect Server online',
            'time' => now()->toIso8601String(),
        ]);
    });

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/me', [AuthController::class, 'me']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/profile', ['App\\Http\\Controllers\\Api\\ProfileController', 'update']);
            Route::post('/profile/wallpaper', [\App\Http\Controllers\Api\ProfileController::class, 'updateWallpaper']);
            Route::delete('/profile/wallpaper', [\App\Http\Controllers\Api\ProfileController::class, 'deleteWallpaper']);
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/fcm-token', [\App\Http\Controllers\Api\FCMController::class, 'updateToken']);

        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users/sync-contacts', [UserController::class, 'syncContacts']);
        
        Route::get('/settings', [SettingsController::class, 'show']);
        Route::put('/settings', [SettingsController::class, 'update']);
        
        Route::get('/conversations', [ConversationController::class, 'index']);
        Route::post('/conversations', [ConversationController::class, 'store']);
        Route::post('/conversations/group', [ConversationController::class, 'storeGroup']);
        Route::delete('/conversations/{conversation}', [ConversationController::class, 'destroy']);
        
        Route::get('/calls', [CallController::class, 'index']);
        Route::post('/calls', [CallController::class, 'store']);
        
        // Stories
        Route::get('/stories', [StoryController::class, 'index']);
        Route::post('/stories', [StoryController::class, 'store']);
        Route::delete('/stories/{story}', [StoryController::class, 'destroy']);
        Route::post('/stories/{story}/view', [StoryController::class, 'view']);
        
        Route::get('/conversations/{conversation}/messages', [MessageController::class, 'index']);
        Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store']);
        Route::post('/conversations/{conversation}/read', [MessageController::class, 'markAsRead']);
        Route::post('/messages/mark-all-read', [MessageController::class, 'markAllAsRead']);
        Route::post('/messages/{message}/delete', [MessageController::class, 'destroy']);
        Route::post('/messages/{message}/react', [MessageController::class, 'react']);
    });
});
