<?php

namespace Modules\Patient\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Patient\app\DTO\AddressData;
use Spatie\LaravelData\WithData;

class AddressRequest extends FormRequest
{
    use WithData;
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'cep' => [
                'bail',
                Rule::requiredIf($this->routeIs('address.create')),
                'between:8,8',
                'regex:/^[0-9]+$/'
            ],
            'address' => [
                'bail',
                Rule::requiredIf($this->routeIs('address.create')),
                'string'
            ],
            'number' => [
                'bail',
                Rule::requiredIf($this->routeIs('address.create')),
                'string',
                'regex:/^[0-9]+$/'
            ],
            'complement' => [
                'bail',
                Rule::requiredIf($this->routeIs('address.create')),
                'string',
            ],
            'neighbour' => [
                'bail',
                Rule::requiredIf($this->routeIs('address.create')),
                'string',
            ],
            'city' => [
                'bail',
                Rule::requiredIf($this->routeIs('address.create')),
                'string',
            ],
            'state' => [
                'bail',
                Rule::requiredIf($this->routeIs('address.create')),
                'string',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'regex' => 'O :attribute deve conter apenas números.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function dataClass(): string
    {
        return AddressData::class;
    }
}
