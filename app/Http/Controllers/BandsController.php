<?php

namespace App\Http\Controllers;

use App\Models\Band;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BandsController extends Controller
{
    public function index(): JsonResponse
    {
        $bands = Band::all();
        return response()->json($bands);
    }

    public function show($id): JsonResponse
    {
        try {
            $band = Band::findOrFail($id);
            return response()->json($band);
        } catch (\Throwable $th) {
            return response()->json(["message"=> $th->getMessage()]);
        }
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $validatedData = $this->validateCreateData($request);
            $band = Band::create($validatedData);
            return response()->json($band);
            } catch (\Throwable $th) {
                return response()->json(["message"=> $th->getMessage()]);
        }

    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $band = Band::findOrFail($id);

            $validatedData = $this->validateUpdateData($request);

            $band->update($validatedData);

            return response()->json([
                'message' => 'Band updated successfully',
                'band' => $band
            ]);

        } catch (\Throwable $th) {
            return response()->json(["message"=> $th->getMessage()]);
        }
    }

    public function destroy($id): JsonResponse
    {
        $band = Band::findOrFail($id);
        $band->delete();
        return response()->json(["message"=> "Band deleted successfully"]);
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
            'name'          => 'sometimes|string',
            'country'      => 'sometimes|string',
            'genres'       => 'sometimes|array',
            'formed_at'    => 'sometimes|date',
            'disbanded_at' => 'nullable|date',
        ]);
    }
}
