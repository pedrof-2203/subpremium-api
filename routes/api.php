<?php

use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\AlbumRatingsController;
use App\Http\Controllers\ArtistsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BandsController;
use App\Http\Controllers\SongsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('bands', BandsController::class);
    Route::apiResource('artists', ArtistsController::class);
    Route::apiResource('albums', AlbumsController::class);
    Route::apiResource('songs', SongsController::class);
    Route::apiResource('album-ratings', AlbumRatingsController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});





