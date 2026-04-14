<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreBandRequest
 *
 * Handles authorization and validation rules for creating and updating Band models.
 * Automatically adapts requirements (e.g., `required` vs `sometimes`) based on 
 * the HTTP method (POST for creation vs PUT/PATCH for updates).
 *
 * @package App\Http\Requests
 */
class StoreBandRequest extends FormRequest
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
     * Applies conditional logic to require fields during creation (POST)
     * but only validates them if present during an update (PUT/PATCH).
     * Includes custom cross-field validation ensuring disbanded_at > formed_at.
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
            'formed_at'    => ($isUpdate ? 'sometimes' : 'required') . '|date',
            'disbanded_at' => 'nullable|date|after:formed_at', 
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome da banda é obrigatório.',
            'formed_at.date' => 'A data de formação deve ser uma data válida.',
            'disbanded_at.after' => 'A data de encerramento deve ser posterior à data de formação.',
        ];
    }
}
