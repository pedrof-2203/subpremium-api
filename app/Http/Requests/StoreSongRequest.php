<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSongRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * (for now we return true since authorization isn't part of the task)
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * We switch rules based on HTTP verb so that POST requires all fields and
     * PUT/PATCH only validates "sometimes" for partial updates.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        // common rules used in both scenarios
        $base = [
            'artist_id' => 'sometimes|exists:artists,id',
            'band_id' => 'sometimes|exists:bands,id',
            'album_id' => 'sometimes|exists:albums,id',
            // when performing PATCH/PUT the presence is optional, so use sometimes
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'genres' => 'sometimes|array',
            'release_date' => 'sometimes|date',
        ];

        if ($this->isMethod('post')) {
            // POST: make required where appropriate
            return array_merge($base, [
                'title' => 'required|string',
                'description' => 'required|string',
                'genres' => 'required|array',
                'release_date' => 'required|date',
            ]);
        }

        // PUT/PATCH: allow partial updates
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return $base; // 'sometimes' is already in base for foreign keys
        }

        // Default fallback
        return $base;
    }
}
