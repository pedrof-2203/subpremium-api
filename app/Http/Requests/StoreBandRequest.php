<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
