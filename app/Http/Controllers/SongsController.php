<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Http\Requests\StoreSongRequest;
use App\Http\Resources\SongResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SongsController extends Controller
{
    public function index()
    {
        // return a resource collection, let Laravel wrap in "data" key automatically
        return SongResource::collection(Song::all());
    }

    // route model binding will automatically return 404 if not found
    public function show(Song $song)
    {
        return new SongResource($song);
    }

    public function store(StoreSongRequest $request)
    {
        $song = Song::create($request->validated());
        return (new SongResource($song))
                    ->response()
                    ->setStatusCode(201);
    }

    public function update(StoreSongRequest $request, Song $song)
    {
        $song->update($request->validated());
        return new SongResource($song);
    }

    public function destroy(Song $song): JsonResponse
    {
        $song->delete();
        return response()->json(["message"=> "Song deleted successfully"]);
    }

}
