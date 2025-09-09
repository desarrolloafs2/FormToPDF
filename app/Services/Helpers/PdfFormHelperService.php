<?php

namespace App\Services\Helpers;

use Carbon\Carbon;

class PdfFormHelperService
{
    public function capitalize(string $value): string
    {
        return mb_convert_case(mb_strtolower($value, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }

    public function normalizeValue($value, string $group): ?string
    {
        if ($value === null)
            return null;

        if ($this->isRadioGroup($group)) {
            return trim((string) $value);
        }

        $val = strtolower(trim((string) $value));

        return match ($val) {
            '1', 'sí', 'si', 'on' => 'sí',
            '0', '2', 'no' => 'no',
            '' => null,
            default => $value,
        };
    }

    public function normalizeOption($value): string
    {
        return strtolower(trim(html_entity_decode((string) $value)));
    }

    public function getYesOption(array $options): string
    {
        foreach ($options as $opt) {
            if ($opt !== 'Off')
                return html_entity_decode($opt, ENT_QUOTES, 'UTF-8');
        }
        return 'Sí';
    }

    public function isYesNoPair(string $group): bool
    {
        return in_array($group, [
            'ambito_rural',
            'politicas_sostenibilidad',
            'transformacion_digital',
            'mujer_responsable',
            'reside_en_localidad_menor_5000',
        ]);
    }

    public function isRadioGroup(string $group): bool
    {
        return in_array($group, [
            'nivel_estudios',
            'situacion_actual',
            'facturacion',
            'tamano_empresa',
            'antiguedad_empresa',
            'porcentaje_mujeres',
            'relacion_empresa',
        ]);
    }

    public function handleYesNoPair(string $group, string $pdfField, array $mappedValues): string
    {
        $groupConfig = config("eoi.$group");
        $yesOptionField = $groupConfig['sí'] ?? null;
        $noOptionField = $groupConfig['no'] ?? null;

        $value = $mappedValues[0] ?? null;
        if (!$value)
            return 'Off';

        if ($pdfField === $yesOptionField && $value === 'sí')
            return 'Sí';
        if ($pdfField === $noOptionField && $value === 'no')
            return 'Sí';

        return 'Off';
    }

    public function handleRadioGroup(string $group, string $option, string $pdfField, array $mappedValues): string
    {
        $value = $mappedValues[0] ?? null;
        if (!$value)
            return 'Off';

        $normalizedValue = $this->normalizeOption($value);
        $normalizedOption = $this->normalizeOption($option);

        return $normalizedValue === $normalizedOption ? 'Sí' : 'Off';
    }

    public function handleMappedOption(array $pdfOptions, array $mappedValues): string
    {
        $decodedPdfOptions = array_map(fn($v) => html_entity_decode($v, ENT_QUOTES, 'UTF-8'), $pdfOptions);
        $normalizedMapped = array_map([$this, 'normalizeOption'], $mappedValues);
        $normalizedPdf = array_map([$this, 'normalizeOption'], $decodedPdfOptions);

        foreach ($decodedPdfOptions as $i => $opt) {
            if ($opt === 'Off')
                continue;
            if (in_array($normalizedPdf[$i], $normalizedMapped, true)) {
                return $opt;
            }
        }

        return 'Off';
    }

    /**
     * Maneja valores de radios → devuelve 'On' si está marcado, '' si no
     */
    public function handleRadioOption(?string $value, string $expected = 'On'): string
    {
        return (!empty($value) && strtolower($value) !== 'off') ? $expected : '';
    }

    /**
     * Formatea fechas a d/m/Y → devuelve '' si no hay fecha
     */
    public function formatDate(?string $date, string $outputFormat = 'd/m/Y'): string
    {
        if (empty($date)) {
            return '';
        }

        try {
            // Detectar si viene como YYYY-MM-DD (formato HTML)
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return Carbon::createFromFormat('Y-m-d', $date)->format($outputFormat);
            }

            // Detectar si viene como DD/MM/YYYY
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
                return Carbon::createFromFormat('d/m/Y', $date)->format($outputFormat);
            }

            // Último intento: parsear genérico
            return Carbon::parse($date)->format($outputFormat);

        } catch (\Exception $e) {
            return '';
        }
    }

}
