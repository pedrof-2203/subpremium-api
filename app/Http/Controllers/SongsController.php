<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SongsController extends Controller
{
    public function index(): JsonResponse
    {
        $songs = Song::all();
        return response()->json($songs);
    }

    public function show($id): JsonResponse
    {
        try {
            $song = Song::findOrFail($id);
            return response()->json($song);
        } catch (\Throwable $th) {
            return response()->json(["message"=> $th->getMessage()]);
        }
    }

    public function create(Request $request): JsonResponse
    {
        $validatedData = $this->validateCreateData($request);
        $song = Song::create($validatedData);
        return response()->json($song);
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $song = Song::findOrFail($id);

            $validatedData = $this->validateUpdateData($request);

            $song->update($validatedData);

            return response()->json([
                'message' => 'Song updated successfully',
                'song' => $song
            ]);

        } catch (\Throwable $th) {
            return response()->json(["message"=> $th->getMessage()]);
        }
    }

    public function destroy($id): JsonResponse
    {
        $song = Song::findOrFail($id);
        $song->delete();
        return response()->json(["message"=> "Song deleted successfully"]);
    }

    private function validateCreateData(Request $request): array
    {
        return $request->validate([
            'artist_id' => 'sometimes|exists:artists,id',
            'band_id' => 'sometimes|exists:bands,id',
            'album_id' => 'sometimes|exists:albums,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'genres' => 'required|array',
            'release_date' => 'required|date',
        ]);
    }

    private function validateUpdateData(Request $request): array
    {
        return $request->validate([
            'artist_id' => 'sometimes|exists:artists,id',
            'band_id' => 'sometimes|exists:bands,id',
            'album_id' => 'sometimes|exists:albums,id',
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'genres' => 'sometimes|array',
            'release_date' => 'sometimes|date',
        ]);
    }
}
