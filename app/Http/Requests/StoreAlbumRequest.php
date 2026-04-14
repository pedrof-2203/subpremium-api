<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreAlbumRequest
 *
 * Handles authorization and dynamic validation rules for creating and updating Album models.
 * Reuses validation arrays between POST (create) and PUT/PATCH (update) where 'required'
 * fields become 'sometimes' during updates.
 *
 * @package App\Http\Requests
 */
class StoreAlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');
    
        return [
            'artist_id'    => 'nullable|exists:artists,id',
            'band_id'      => 'nullable|exists:bands,id',
            'title'        => [$isUpdate ? 'sometimes' : 'required', 'string', 'max:255'],
            'description'  => [$isUpdate ? 'sometimes' : 'required', 'string'],
            'genres'       => [$isUpdate ? 'sometimes' : 'required', 'array'],
            'release_date' => [$isUpdate ? 'sometimes' : 'required', 'date'],
        ];
    }
}
