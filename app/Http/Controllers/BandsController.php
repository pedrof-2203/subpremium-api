<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Http\Requests\StoreBandRequest; 
use App\Http\Resources\BandResource;   
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BandsController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BandResource::collection(Band::paginate(10));
    }

    public function show(Band $band): BandResource
    {
        return new BandResource($band);
    }

    public function store(StoreBandRequest $request): JsonResponse
    {
        $band = Band::create($request->validated());
        
        return (new BandResource($band))
            ->response()
            ->setStatusCode(201);
    }

    public function update(StoreBandRequest $request, Band $band): BandResource
    {
        $band->update($request->validated());
        return new BandResource($band);
    }

    public function destroy(Band $band): JsonResponse
    {
        $band->delete();
        return response()->json(["message" => "Band deleted successfully"], 204);
    }
}