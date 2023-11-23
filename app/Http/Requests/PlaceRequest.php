<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PlaceRequest extends FormRequest
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
        return [
            'name' => 'required|min:3',
            'city' => 'required|min:3',
            'state' => 'required|size:2',
            'slug' => [
                'required',
                'min:3',
                Rule::unique('places', 'slug')->ignore($this->place),
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'name.min' => 'O campo nome deve ter no mínimo 3 caracteres',
            'city.required' => 'O campo cidade é obrigatório',
            'city.min' => 'O campo cidade deve ter no mínimo 3 caracteres',
            'state.required' => 'O campo estado é obrigatório',
            'state.size' => 'O campo estado deve ter 2 caracteres',
            'slug.required' => 'O campo slug é obrigatório',
            'slug.min' => 'O campo slug deve ter no mínimo 3 caracteres',
            'slug.unique' => 'O campo slug deve ser único'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Houve um problema com os dados fornecidos.',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
