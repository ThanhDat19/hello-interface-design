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

    // Thẻ
    Route::prefix('card')->group(function () {
        Route::get('getData', [CardAPIController::class, 'getData'])->name('api.card');
        Route::post('create', [CardAPIController::class, 'create'])->name('api.card.create');
        Route::post('edit/{id}', [CardAPIController::class, 'edit'])->name('api.card.edit');
        Route::get('getDataEdit/{id}', [CardAPIController::class, 'getDataEdit'])->name('api.card.edit.getdata');
    });
    
    // Loại thẻ
    Route::get('card-type/getDataHandle', [CardTypeAPIController::class, 'getDataHandle'])->name('api.handle.cardtype');

});

