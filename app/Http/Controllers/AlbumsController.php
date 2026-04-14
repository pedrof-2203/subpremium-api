<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlbumsController extends Controller
{
    public function index(): JsonResponse
    {
        $albums = Album::all();

        return response()->json($albums);
    }

    public function show($id): JsonResponse
    {
        try {
            $album = Album::findOrFail($id);

            return response()->json($album);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
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
