<?php

namespace Modules\Patient\app\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Respect\Validation\Validator;

class Cpf implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Validator::cpf()->validate($value)) {
            $fail('O campo :attribute não é um CPF válido.');
        }
    }
}
