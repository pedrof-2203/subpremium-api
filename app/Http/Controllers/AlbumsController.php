<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Http\Resources\AlbumResource;
use App\Models\Album;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AlbumsController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return AlbumResource::collection(Album::all());
    }

    public function show(Album $album): AlbumResource
    {
        return new AlbumResource($album);
    }

    public function store(StoreAlbumRequest $request): AlbumResource
    {
        $album = Album::create($request->validated());
        
        return new AlbumResource($album);
    }

    public function update(StoreAlbumRequest $request, Album $album): AlbumResource
    {
        $album->update($request->validated());

        return new AlbumResource($album);
    }

    public function destroy(Album $album)
    {
        $album->delete();

        return response()->json([
            'message' => 'Album deletado com sucesso'
        ], 200);
    }
}