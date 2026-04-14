<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlbumsController extends Controller
{
    /**
     * Fetch all albums.
     *
     * Retrieves a list of all raw Album models from the database.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing a collection of Album objects.
     */
    public function index(): JsonResponse
    {
        $albums = Album::all();

        return response()->json($albums);
    }

    /**
     * Fetch a single album by ID.
     *
     * Retrieves an existing album by its primary key. Catches failure 
     * if the model does not exist and returns a standard error message.
     *
     * @param int|string $id The ID of the album to fetch.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing the single Album object or an error message.
     */
    public function show($id): JsonResponse
    /**
     * Create a new album.
     *
     * Validates the incoming request and generates a new record in the database.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing the newly created Album object.
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails.
     */
    {
        try {
            $album = Album::findOrFail($id);

            return response()->json($album);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
    /**
     * Update an existing album.
     *
     * Finds the album by ID, validates the provided fields, and updates the record.
     * Exceptions (such as model not found) are caught and returned as JSON.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing fields to update.
     * @param int|string $id The ID of the album to update.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing a success message and the updated album, or an error message.
     */
        }
    }

    public function create(Request $request): JsonResponse
    {
        $validatedData = $this->validateCreateData($request);
        $album = Album::create($validatedData);

        return response()->json($album);
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $album = Album::findOrFail($id);

            $validatedData = $this->validateUpdateData($request);

            $album->update($validatedData);
/**
     * Delete an existing album.
     *
     * Permanently deletes the corresponding album record from the database.
     * Throws an exception if the model is not found, handled implicitly or globally.
     *
     * @param int|string $id The ID of the album to delete.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing a success message.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the album is not found.
     */
    
            return response()->json([
                'message' => 'Album updated successfully',
                'album' => $album,
            ]);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function destroy($id): JsonResponse
    {
        $album = Album::findOrFail($id);
        $album->delete();

        return response()->json(['message' => 'Album deleted successfully']);
    }

    private function validateCreateData(Request $request): array
    {
        return $request->validate([
            'artist_id' => 'sometimes|exists:artists,id',
            'band_id' => 'sometimes|exists:bands,id',
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
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'genres' => 'sometimes|array',
            'release_date' => 'sometimes|date',
        ]);
    }
}
