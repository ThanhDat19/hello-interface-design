<?php

use App\Http\Controllers\Admin\CardController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth.verify', 'auth.checkrole.manager'])->group(function(){
    // Dashboard
    Route::get('/', [HomeController::class, 'index'])->name('manager.home');

    // Người chơi
    Route::get('/user', [UserController::class, 'index'])->name('manager.user');

    // Thẻ
    Route::prefix('card')->group(function () {
        Route::get('/', [CardController::class, 'index'])->name('manager.card');
        Route::get('/create', [CardController::class, 'create'])->name('manager.card.create');
        Route::get('/edit/{id}', [CardController::class, 'edit'])->name('manager.card.edit');
    });
    
});