<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreArtistRequest
 *
 * Handles authorization and validation for the Artist model endpoints.
 * Automatically adapts `required` validation logic depending on if the request 
 * is a creation (POST) or an update (PUT/PATCH).
 *
 * @package App\Http\Requests
 */
class StoreArtistRequest extends FormRequest
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
        $isUpdate = $this->isMethod("put") || $this->isMethod("patch");

        return [
            'name'         => ($isUpdate ? 'sometimes' : 'required') . '|string|max:255',
            'country'      => ($isUpdate ? 'sometimes' : 'required') . '|string|max:100',
            'genres'       => ($isUpdate ? 'sometimes' : 'required') . '|array',
            'birthday'     => ($isUpdate ? 'sometimes' : 'required') . '|date',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do artista é obrigatório.',
            'birthday.date' => 'A data de nascimento deve ser uma data válida.',
        ];
    }
}
