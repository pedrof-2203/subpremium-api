<?php

namespace App\Http\Controllers;

use App\Models\Band;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BandsController extends Controller
{
    /**
     * Fetch all bands.
     *
     * Retrieves a list of all raw Band models from the database.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing a collection of Band objects.
     */
    public function index(): JsonResponse
    {
        $bands = Band::all();

        return response()->json($bands);
    }

    /**
     * Fetch a single band by ID.
     *
     * Retrieves an existing band by its primary key. Catches failure 
     * if the model does not exist and returns a standard error message.
     *
     * @param int|string $id The ID of the band to fetch.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing the single Band object or an error message.
     */
    public function show($id): JsonResponse
    /**
     * Create a new band.
     *
     * Validates the incoming request and generates a new record in the database.
     * Catches validation or database exceptions and returns them gracefully.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing the newly created Band object or an error message.
     */
    {
        try {
            $band = Band::findOrFail($id);

            return response()->json($band);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function create(Request $request): JsonResponse
    {
        try {
    /**
     * Update an existing band.
     *
     * Finds the band by ID, validates the provided fields, and updates the record.
     * Exceptions (such as model not found) are caught and returned as JSON.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing fields to update.
     * @param int|string $id The ID of the band to update.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing a success message and the updated band, or an error message.
     */
            $validatedData = $this->validateCreateData($request);
            $band = Band::create($validatedData);

            return response()->json($band);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }

    /**
     * Delete an existing band.
     *
     * Soft deletes the corresponding band record from the database.
     * Throws an exception if the model is not found, handled implicitly or globally.
     *
     * @param int|string $id The ID of the band to delete.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing a success message.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the band is not found.
     */
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $band = Band::findOrFail($id);

            $validatedData = $this->validateUpdateData($request);

            $band->update($validatedData);

            return response()->json([
                'message' => 'Band updated successfully',
                'band' => $band,
            ]);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function destroy($id): JsonResponse
    {
        $band = Band::findOrFail($id);
        $band->delete();

        return response()->json(['message' => 'Band deleted successfully']);
    }

    private function validateCreateData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'country' => 'required|string',
            'genres' => 'required|array',
            'formed_at' => 'required|date',
            'disbanded_at' => 'nullable|date',
        ]);
    }

    private function validateUpdateData(Request $request): array
    {
        return $request->validate([
            'name' => 'sometimes|string',
            'country' => 'sometimes|string',
            'genres' => 'sometimes|array',
            'formed_at' => 'sometimes|date',
            'disbanded_at' => 'nullable|date',
        ]);
    }
}
