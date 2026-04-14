<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Http\Requests\StoreBandRequest; 
use App\Http\Resources\BandResource;   
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AlbumRatingsController extends Controller
{
    /**
     * Fetch all bands (currently within AlbumRatingsController).
     *
     * Retrieves a paginated list of Band models, wrapped in a Resource Collection.
     * Note: This controller currently returns Band resources.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Collection of BandResource.
     */
    public function index(): AnonymousResourceCollection
    {
        return BandResource::collection(Band::paginate(10));
    }

    /**
     * Fetch a single band (currently within AlbumRatingsController).
     *
     * Retrieves an existing band using Implicit Route Model Binding and returns it wrapped in a Resource.
     * Note: This controller currently returns Band resources.
     *
     * @param \App\Models\Band $band The implicitly bound band model.
     * 
     * @return \App\Http\Resources\BandResource
     */
    public function show(Band $band): BandResource
    {
        return new BandResource($band);
    }

    /**
     * Create a new band (currently within AlbumRatingsController).
     *
     * Validates the request using StoreBandRequest and creates a new band explicitly returning a 201 status.
     * Note: This controller currently creates Band resources.
     *
     * @param \App\Http\Requests\StoreBandRequest $request The validated incoming request.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing the newly created BandResource.
    /**
     * Update an existing band (currently within AlbumRatingsController).
     *
     * Validates and updates the bound band using StoreBandRequest, returning the updated resource.
     * Note: This controller currently updates Band resources.
     *
     * @param \App\Http\Requests\StoreBandRequest $request The validated incoming request.
     * @param \App\Models\Band $band The implicitly bound band model to update.
     * 
     * @return \App\Http\Resources\BandResource
     */
     */
    public function store(StoreBandRequest $request): JsonResponse
    {
        $band = Band::create($request->validated());
        
    /**
     * Delete an existing band (currently within AlbumRatingsController).
     *
     * Deletes the implicitly bound band model and returns an empty 204 JSON response.
     * Note: This controller currently deletes Band resources.
     *
     * @param \App\Models\Band $band The implicitly bound band model to delete.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response containing a success message with 204 status.
     */
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