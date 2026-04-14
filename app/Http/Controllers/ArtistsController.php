<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    /**
     * Fetch all artists.
     *
     * Retrieves a list of all raw Artist models from the database.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing a collection of Artist objects.
     */
    public function index(): JsonResponse
    {
        $artists = Artist::all();

        return response()->json($artists);
    }

    /**
     * Fetch a single artist by ID.
     *
     * Retrieves an existing artist by its primary key. Catches failure 
     * if the model does not exist and returns a standard error message.
     *
     * @param int|string $id The ID of the artist to fetch.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing the single Artist object or an error message.
     */
    public function show($id): JsonResponse
    {
        try {
            $artist = Artist::findOrFail($id);

            return response()->json($artist);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    /**
     * Create a new artist.
     *
     * Validates the incoming request and generates a new record in the database.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing the newly created Artist object.
    /**
     * Update an existing artist.
     *
     * Finds the artist by ID, validates the provided fields, and updates the record.
     * Exceptions (such as model not found) are caught and returned as JSON.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing fields to update.
     * @param int|string $id The ID of the artist to update.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing a success message and the updated artist, or an error message.
     */
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails.
     */
    public function create(Request $request): JsonResponse
    {
        $validatedData = $this->validateCreateData($request);
        $artist = Artist::create($validatedData);

        return response()->json($artist);
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $artist = Artist::findOrFail($id);

            $validatedData = $this->validateUpdateData($request);

            $artist->update($validatedData);
/**
     * Delete an existing artist.
     *
     * Permanently deletes the corresponding artist record from the database.
     * Throws an exception if the model is not found, handled implicitly or globally.
     *
     * @param int|string $id The ID of the artist to delete.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing a success message.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the artist is not found.
     */
    
            return response()->json([
                'message' => 'Artist updated successfully',
                'artist' => $artist,
            ]);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function destroy($id): JsonResponse
    {
        $artist = Artist::findOrFail($id);
        $artist->delete();

        return response()->json(['message' => 'Artist deleted successfully']);
    }

    private function validateCreateData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'country' => 'required|string',
            'birthday' => 'required|date',
            'genres' => 'required|array',
        ]);
    }

    private function validateUpdateData(Request $request): array
    {
        return $request->validate([
            'name' => 'sometimes|string',
            'country' => 'sometimes|string',
            'birthday' => 'sometimes|date',
            'genres' => 'sometimes|array',
        ]);
    }
}
