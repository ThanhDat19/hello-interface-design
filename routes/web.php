<?php

use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [LoginController::class, 'login']);
Route::get('/save-token', [LoginController::class, 'saveToken']);
Route::get('/', [HomeController::class, 'index']);
Route::middleware(['auth.verify'])->group(function(){
   
});

