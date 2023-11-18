<?php

namespace Modules\Patient\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CepRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'cep' => [
                'bail',
                'required',
                'between:8,8',
                'regex:/^[0-9]+$/'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'cep.regex' => 'O CEP deve conter apenas números',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
