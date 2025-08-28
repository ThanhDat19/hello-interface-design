<?php

use App\Http\Controllers\Api\AuthAPIController;
use App\Http\Controllers\Api\CardAPIController;
use App\Http\Controllers\Api\CardTypeAPIController;
use App\Http\Controllers\Api\UploadFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthAPIController::class, 'login']);
Route::group(['middleware' => ['jwt.verify'], 'provider' => ['jwt']], function () {
    Route::post('/logout', [AuthAPIController::class, 'logout']);
    Route::get('/check-login', [AuthAPIController::class, 'checkLogin'] );

    // Test upload file
    Route::post('/upload-file-demo', [UploadFileController::class, 'demo']);

    // Thẻ - Card Management APIs
    Route::prefix('card')->group(function () {
        Route::get('getData', [CardAPIController::class, 'getData'])->name('api.card');
        Route::get('search-advanced', [CardAPIController::class, 'searchAdvanced'])->name('api.card.search.advanced');
        Route::get('{id}', [CardAPIController::class, 'show'])->name('api.card.show');
        Route::post('create', [CardAPIController::class, 'create'])->name('api.card.create');
        Route::post('edit/{id}', [CardAPIController::class, 'update'])->name('api.card.edit');
        Route::put('{id}', [CardAPIController::class, 'update'])->name('api.card.update');
        Route::delete('{id}', [CardAPIController::class, 'destroy'])->name('api.card.destroy');
        Route::get('getDataEdit/{id}', [CardAPIController::class, 'show'])->name('api.card.edit.getdata');
    });
    
    // Loại thẻ - Card Type Management APIs
    Route::prefix('card-type')->group(function () {
        Route::get('getDataHandle', [CardTypeAPIController::class, 'getDataHandle'])->name('api.handle.cardtype');
        Route::get('getData', [CardTypeAPIController::class, 'getDataHandle'])->name('api.cardtype.list');
        Route::get('{id}', [CardTypeAPIController::class, 'show'])->name('api.cardtype.show');
        Route::post('/', [CardTypeAPIController::class, 'create'])->name('api.cardtype.create');
        Route::put('{id}', [CardTypeAPIController::class, 'update'])->name('api.cardtype.update');
        Route::delete('{id}', [CardTypeAPIController::class, 'destroy'])->name('api.cardtype.destroy');
    });

});

// Public APIs (không cần xác thực)
Route::prefix('public')->group(function () {
    Route::get('card-types', [CardTypeAPIController::class, 'getDataHandle'])->name('api.public.cardtypes');
    Route::get('cards/search', [CardAPIController::class, 'searchAdvanced'])->name('api.public.cards.search');
});

