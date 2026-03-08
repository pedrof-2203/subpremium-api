<?php

use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\ArtistsController;
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
    Route::get('/', [ArtistsController::class, 'index']);
    Route::get('/{id}', [ArtistsController::class, 'show']);
    Route::post('/', [ArtistsController::class, 'create']);    
    Route::put('/{id}', [ArtistsController::class, 'update']); 
    Route::delete('/{id}', [ArtistsController::class, 'destroy']); 
});

Route::prefix('albums')->group(function () {
    Route::get('/', [AlbumsController::class, 'index']);
    Route::get('/{id}', [AlbumsController::class, 'show']);
    Route::post('/', [AlbumsController::class, 'create']);    
    Route::put('/{id}', [AlbumsController::class, 'update']); 
    Route::delete('/{id}', [AlbumsController::class, 'destroy']); 
});

