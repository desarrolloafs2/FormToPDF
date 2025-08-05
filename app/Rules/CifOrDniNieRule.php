<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CifOrDniNieRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = strtoupper(trim($value));

        // Accept DNI or NIE
        $dniNie = new DniNieRule();
        $hasDniNie = true;
        $dniNie->validate($attribute, $value, function() use (&$hasDniNie) {
            $hasDniNie = false;
        });

        if ($hasDniNie) return;

        // CIF check
        if (!preg_match('/^[ABCDEFGHJNPQRSUVW][0-9]{7}[0-9A-J]$/', $value)) {
            $fail('El formato de CIF es inválido');
            return;
        }

        $letters = 'JABCDEFGHI';
        $control = substr($value, -1);
        $digits = substr($value, 1, 7);

        $sumA = $sumB = 0;
        for ($i = 0; $i < strlen($digits); $i++) {
            $n = intval($digits[$i]);
            if ($i % 2 === 0) {
                $prod = $n * 2;
                $sumA += intval($prod / 10) + ($prod % 10);
            } else {
                $sumB += $n;
            }
        }

        $total = $sumA + $sumB;
        $controlDigit = (10 - ($total % 10)) % 10;
        $controlLetter = $letters[$controlDigit];
        $firstChar = $value[0];

        if (in_array($firstChar, ['A', 'B', 'E', 'H'])) {
            if ($control !== (string) $controlDigit) {
                $fail('El formato de CIF es inválido');
            }
        } elseif (in_array($firstChar, ['K', 'P', 'Q', 'S'])) {
            if ($control !== $controlLetter) {
                $fail('El formato de CIF es inválido');
            }
        } else {
            if (!in_array($control, [(string) $controlDigit, $controlLetter])) {
                $fail('El formato de CIF es inválido');
            }
        }
    }
}
