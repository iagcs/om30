<?php

namespace Modules\Patient\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Patient\app\DTO\PatientData;
use Modules\Patient\app\Rules\Cns;
use Modules\Patient\app\Rules\Cpf;
use Spatie\LaravelData\WithData;

class PatientRequest extends FormRequest
{
    use WithData;
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'full_name' => [
                'bail',
                Rule::requiredIf($this->routeIs('patient.create')),
                'string'
            ],
            'mothers_full_name' => [
                'bail',
                Rule::requiredIf($this->routeIs('patient.create')),
                'string'
            ],
            'date_of_birth' => [
                'bail',
                Rule::requiredIf($this->routeIs('patient.create')),
                'date',
                'date_format:d-m-Y'
            ],
            'cpf' => [
                'bail',
                Rule::requiredIf($this->routeIs('patient.create')),
                'string',
                new Cpf()
            ],
            'cns' => [
                'bail',
                Rule::requiredIf($this->routeIs('patient.create')),
                'string',
                new Cns()
            ]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function dataClass(): string
    {
        return PatientData::class;
    }
}
