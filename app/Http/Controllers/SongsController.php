<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SongsController extends Controller
{
    /**
     * Fetch all songs.
     *
     * Retrieves a list of all raw Song models from the database.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing a collection of Song objects.
     */
    public function index(): JsonResponse
    {
        $songs = Song::all();

        return response()->json($songs);
    }

    /**
     * Fetch a single song by ID.
     *
     * Retrieves an existing song by its primary key. Catches failure 
     * if the model does not exist and returns a standard error message.
     *
     * @param int|string $id The ID of the song to fetch.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing the single Song object or an error message.
     */
    public function show($id): JsonResponse
    {
        try {
            $song = Song::findOrFail($id);

            return response()->json($song);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    /**
     * Create a new song.
     *
     * Validates the incoming request and generates a new record in the database.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing the newly created Song object.
    /**
     * Update an existing song.
     *
     * Finds the song by ID, validates the provided fields, and updates the record.
     * Exceptions (such as model not found) are caught and returned as JSON.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing fields to update.
     * @param int|string $id The ID of the song to update.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing a success message and the updated song, or an error message.
     */
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails.
     */
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
/**
     * Delete an existing song.
     *
     * Permanently deletes the corresponding song record from the database.
     * Throws an exception if the model is not found, handled implicitly or globally.
     *
     * @param int|string $id The ID of the song to delete.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing a success message.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the song is not found.
     */
    
            return response()->json([
                'message' => 'Song updated successfully',
                'song' => $song,
            ]);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function destroy($id): JsonResponse
    {
        $song = Song::findOrFail($id);
        $song->delete();

        return response()->json(['message' => 'Song deleted successfully']);
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
