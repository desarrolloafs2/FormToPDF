<?php

namespace App\Traits;

trait LongTextRules
{
    /**
     * Regla estándar para campos de texto requeridos
     */
    protected function textRule(int $min = 3, int $max = 255): array
    {
        return ['required', 'string', "min:{$min}", "max:{$max}"];
    }


    protected function selectRule(array $values): array
    {
        return ['required', 'in:' . implode(',', $values)];
    }

    protected function booleanRule(): array
    {
        return ['required', 'in:1,2']; // para radios Sí/No
    }
    
}
