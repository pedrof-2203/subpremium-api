<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    public function index(): JsonResponse
    {
        $artists = Artist::all();
        return response()->json($artists);
    }

    public function show($id): JsonResponse
    {
        try {
            $artist = Artist::findOrFail($id);
            return response()->json($artist);
        } catch (\Throwable $th) {
            return response()->json(["message"=> $th->getMessage()]);
        }
    }

    public function store(Request $request): JsonResponse
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

            return response()->json([
                'message' => 'Artist updated successfully',
                'artist' => $artist
            ]);

        } catch (\Throwable $th) {
            return response()->json(["message"=> $th->getMessage()]);
        }
    }

    public function destroy($id): JsonResponse
    {
        $artist = Artist::findOrFail($id);
        $artist->delete();
        return response()->json(["message"=> "Artist deleted successfully"]);
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
