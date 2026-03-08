<?php

use App\Http\Controllers\BandsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('bands')->group(function () {
    Route::get('/', [BandsController::class, 'index']);
    Route::get('/{id}', [BandsController::class, 'show']);
    Route::post('/', [BandsController::class, 'create']);    // Removido /create
    Route::put('/{id}', [BandsController::class, 'update']); // Removido /update
    Route::delete('/{id}', [BandsController::class, 'destroy']); // Removido /destroy
});