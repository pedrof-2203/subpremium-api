<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\BandsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('bands')->group(function () {
    Route::get('/', [BandsController::class, 'index']);
    Route::get('/{id}', [BandsController::class, 'show']);
    Route::post('/', [BandsController::class, 'create']);    
    Route::put('/{id}', [BandsController::class, 'update']); 
    Route::delete('/{id}', [BandsController::class, 'destroy']); 
});

Route::prefix('artists')->group(function () {
    Route::get('/', [ArtistController::class, 'index']);
    Route::get('/{id}', [ArtistController::class, 'show']);
    Route::post('/', [ArtistController::class, 'create']);    
    Route::put('/{id}', [ArtistController::class, 'update']); 
    Route::delete('/{id}', [ArtistController::class, 'destroy']); 
});