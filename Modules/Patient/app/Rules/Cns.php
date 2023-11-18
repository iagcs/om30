<?php

namespace Modules\Patient\app\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cns implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!$this->validateCns($value)){
            $fail('O campo :attribute não é um CNS válido.');
        }
    }

    public function validateCns($cns): bool
    {
        if (strlen($cns) !== 15) {
            return false;
        }

        $soma = 0;
        $resto = 0;
        $dv = 0;
        $pis = "";
        $resultado = "";

        $pis = substr($cns, 0, 11);

        $soma = ((int) $pis[0]) * 15 + ((int) $pis[1]) * 14 +
                ((int) $pis[2]) * 13 + ((int) $pis[3]) * 12 +
                ((int) $pis[4]) * 11 + ((int) $pis[5]) * 10 +
                ((int) $pis[6]) * 9 + ((int) $pis[7]) * 8 +
                ((int) $pis[8]) * 7 + ((int) $pis[9]) * 6 +
                ((int) $pis[10]) * 5;

        $resto = $soma % 11;
        $dv = 11 - $resto;

        if ($dv === 11) {
            $dv = 0;
        }

        if ($dv === 10) {
            $soma = ((int) $pis[0]) * 15 + ((int) $pis[1]) * 14 +
                    ((int) $pis[2]) * 13 + ((int) $pis[3]) * 12 +
                    ((int) $pis[4]) * 11 + ((int) $pis[5]) * 10 +
                    ((int) $pis[6]) * 9 + ((int) $pis[7]) * 8 +
                    ((int) $pis[8]) * 7 + ((int) $pis[9]) * 6 +
                    ((int) $pis[10]) * 5 + 2;

            $resto = $soma % 11;
            $dv = 11 - $resto;
        }

        $resultado = $pis . "000".(string) $dv;

        return $cns === $resultado;
    }
}
