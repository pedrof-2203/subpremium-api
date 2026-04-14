<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    /**
     * Fetch all artists.
     *
     * Retrieves a list of all Artist models from the database.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing a collection of Artist objects.
     */
    public function index(): JsonResponse
    {
        try {
            $artists = Artist::all();

            return response()->json($artists);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Fetch a single artist by ID.
     *
     * Retrieves an existing artist by its primary key.
     *
     * @param  int|string  $id  The ID of the artist to fetch.
     * @return \Illuminate\Http\JsonResponse JSON response containing the Artist object or an error message.
     */
    public function show(int|string $id): JsonResponse
    {
        try {
            $artist = Artist::findOrFail($id);

            return response()->json($artist);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Artist not found.'], 404);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Create a new artist.
     *
     * Validates the incoming request and creates a new record in the database.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request.
     * @return \Illuminate\Http\JsonResponse JSON response containing the newly created Artist object.
     *
     * @throws \Illuminate\Validation\ValidationException If validation fails.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $this->validateCreateData($request);

        try {
            $artist = Artist::create($validatedData);

            return response()->json([
                'message' => 'Artist created successfully',
                'artist'  => $artist,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Update an existing artist.
     *
     * Finds the artist by ID, validates the provided fields, and updates the record.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request containing fields to update.
     * @param  int|string  $id  The ID of the artist to update.
     * @return \Illuminate\Http\JsonResponse JSON response containing a success message and the updated artist, or an error message.
     *
     * @throws \Illuminate\Validation\ValidationException If validation fails.
     */
    public function update(Request $request, int|string $id): JsonResponse
    {
        try {
            $artist = Artist::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Artist not found.'], 404);
        }

        $validatedData = $this->validateUpdateData($request);

        try {
            $artist->update($validatedData);

            return response()->json([
                'message' => 'Artist updated successfully',
                'artist'  => $artist,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Delete an existing artist.
     *
     * Permanently deletes the corresponding artist record from the database.
     *
     * @param  int|string  $id  The ID of the artist to delete.
     * @return \Illuminate\Http\JsonResponse JSON response containing a success message or an error message.
     */
    public function destroy(int|string $id): JsonResponse
    {
        try {
            $artist = Artist::findOrFail($id);
            $artist->delete();

            return response()->json(['message' => 'Artist deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Artist not found.'], 404);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    private function validateCreateData(Request $request): array
    {
        return $request->validate([
            'name'     => 'required|string',
            'country'  => 'required|string',
            'birthday' => 'required|date',
            'genres'   => 'required|array',
        ]);
    }

    private function validateUpdateData(Request $request): array
    {
        return $request->validate([
            'name'     => 'sometimes|string',
            'country'  => 'sometimes|string',
            'birthday' => 'sometimes|date',
            'genres'   => 'sometimes|array',
        ]);
    }
}