<?php

namespace App\Traits;

trait LongTextRules
{
    /**
     * Regla estándar para campos de texto requeridos
     */
    protected function textRule(int $min = 5, int $max = 255): array
    {
        return ['required', 'string', "min:{$min}", "max:{$max}"];
    }
}
