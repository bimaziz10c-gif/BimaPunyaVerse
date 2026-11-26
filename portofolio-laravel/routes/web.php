<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/kontak', [HomeController::class, 'storeContact'])->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');

    Route::middleware('auth')->group(function (): void {
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/pesan', [AdminController::class, 'messages'])->name('messages');
        Route::get('/skills/create', [AdminController::class, 'createSkill'])->name('skills.create');
        Route::post('/skills', [AdminController::class, 'storeSkill'])->name('skills.store');
        Route::get('/skills/{skill}/edit', [AdminController::class, 'editSkill'])->name('skills.edit');
        Route::put('/skills/{skill}', [AdminController::class, 'updateSkill'])->name('skills.update');
        Route::delete('/skills/{skill}', [AdminController::class, 'destroySkill'])->name('skills.destroy');
    });
});
