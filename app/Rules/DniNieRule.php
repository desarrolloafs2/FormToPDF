<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DniNieRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = strtoupper(trim($value));
        $validLetters = 'TRWAGMYFPDXBNJZSQVHLCKE';

        if (preg_match('/^[0-9]{8}[A-Z]$/', $value)) {
            $number = intval(substr($value, 0, 8));
        } elseif (preg_match('/^[XYZ][0-9]{7}[A-Z]$/', $value)) {
            $prefix = $value[0];
            $prefixNumber = ['X' => '0', 'Y' => '1', 'Z' => '2'][$prefix];
            $number = intval($prefixNumber . substr($value, 1, 7));
        } else {
            $fail('El formato de DNI o NIE es inválido');
            return;
        }

        $expectedLetter = $validLetters[$number % 23];
        $providedLetter = substr($value, -1);

        if ($expectedLetter !== $providedLetter) {
            $fail('El formato de DNI o NIE es inválido');
        }
    }
}
