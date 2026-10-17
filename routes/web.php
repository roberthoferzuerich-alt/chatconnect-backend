<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CallController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::view('/dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/about', [ProfileController::class, 'about'])->name('profile.about');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/wallpaper', [ProfileController::class, 'updateWallpaper'])->name('profile.wallpaper.update');
    Route::delete('/profile/wallpaper', [ProfileController::class, 'deleteWallpaper'])->name('profile.wallpaper.delete');

    // Chats
    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
    Route::match(['get', 'post'], '/chats/start/{user?}', [ChatController::class, 'start'])->name('chats.start');
    Route::get('/chats/{conversation}', [ChatController::class, 'show'])->name('chats.show');
    Route::post('/chats/{conversation}/messages', [ChatController::class, 'store'])->name('chats.store');
    Route::get('/chats/{conversation}/new-messages', [ChatController::class, 'newMessages'])->name('chats.newMessages');
    Route::delete('/messages/{message}', [ChatController::class, 'destroy'])->name('messages.destroy');

    // Calls
    Route::get('/calls', [CallController::class, 'index'])->name('calls.index');
    Route::post('/calls', [CallController::class, 'store'])->name('calls.store');
    Route::get('/calls/room/{room}', [CallController::class, 'room'])->name('calls.room');
    Route::get('/calls/{call}', [CallController::class, 'show'])->name('calls.show');

    // Status
    Route::get('/status', [\App\Http\Controllers\StatusController::class, 'index'])->name('status.index');
    Route::post('/status', [\App\Http\Controllers\StatusController::class, 'store'])->name('status.store');

    // Communities
    Route::get('/communities', [\App\Http\Controllers\CommunityController::class, 'index'])->name('communities.index');
    Route::post('/communities', [\App\Http\Controllers\CommunityController::class, 'store'])->name('communities.store');
    Route::post('/communities/{community}/join', [\App\Http\Controllers\CommunityController::class, 'join'])->name('communities.join');
});

require __DIR__.'/auth.php';

Route::redirect('/web', '/chats');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/download', 'download')->name('download');
Route::view('/guide', 'guide')->name('guide');

