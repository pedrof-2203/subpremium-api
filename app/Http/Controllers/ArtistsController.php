<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArtistRequest;
use App\Http\Resources\ArtistResource;
use App\Models\Artist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    public function index()
    {
        $artists = Artist::all();
        return ArtistResource::collection($artists);
    }

    public function show(Artist $artist)
    {
        return new ArtistResource($artist);
    }

    public function store(StoreArtistRequest $request)
    {
        $artist = Artist::create($request->validated());
        return (new ArtistResource($artist))
            ->response()
            ->setStatusCode(201);
    }

    public function update(StoreArtistRequest $request, Artist $artist)
    {
        $artist->update($request->validated());
        return new ArtistResource($artist);
    }

    public function destroy(Artist $artist)
    {
        $artist->delete();
        return response()->json(["message" => "Artist deleted successfully"]);
    }
}
