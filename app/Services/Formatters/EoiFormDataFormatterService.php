<?php

namespace App\Services\Formatters;

use App\Services\Contracts\PdfFormFormatterInterface;
use App\Services\PdfFieldsResolverService;
use Log;

class EoiFormDataFormatterService implements PdfFormFormatterInterface
{
    private PdfFieldsResolverService $resolver;
    private string $layoutPath;

    public function __construct(PdfFieldsResolverService $resolver)
    {
        $this->resolver = $resolver;
        $this->layoutPath = storage_path('app/' . config('pdf.types.eoi.layout'));
    }

    public function format(array $participant, ?array $companyInfo = null): array
    {
        $data = [];

        // === CAMPOS PERSONALES ===
        foreach (config('eoi.personal_fields') as $pdfField => $formKey) {
            $data[$pdfField] = $participant[$formKey] ?? '';
            if ($data[$pdfField]) {
                $data[$pdfField] = $this->capitalize($data[$pdfField]);
            }
        }

        // === DISCAPACIDAD ===
        $discapacidadField = config('eoi.discapacidad');
        $discapacidadOptions = $this->resolver->getOptions($this->layoutPath, $discapacidadField);
        $yesValue = $this->getYesOption($discapacidadOptions);
        $data[$discapacidadField] = !empty($participant['discapacidad']) ? $yesValue : 'Off';

        // === CAMPOS DE EMPRESA ===
        foreach (config('eoi.company_fields') as $pdfField => $formKey) {
            $data[$pdfField] = $participant[$formKey] ?? '';
            if ($data[$pdfField]) {
                $data[$pdfField] = $this->capitalize($data[$pdfField]);
            }
        }

        // === CHECKBOXES / RADIOS ===
        foreach (config('eoi.option_groups') as $group) {
            $groupMap = config("eoi.$group");
            $rawValues = $participant[$group] ?? [];
            $rawValues = is_array($rawValues) ? $rawValues : [$rawValues];

            // Normalización y mapeo
            $normalizedValues = array_map(fn($v) => $this->normalizeValue($v, $group), $rawValues);
            $mapping = config("eoi.mappings.$group") ?? [];
            $mappedValues = array_map(fn($v) => $mapping[$v] ?? $v, $normalizedValues);

            foreach ($groupMap as $option => $pdfField) {
                $pdfOptions = $this->resolver->getOptions($this->layoutPath, $pdfField);

                if ($this->isYesNoPair($group)) {
                    $data[$pdfField] = $this->handleYesNoPair($group, $pdfField, $mappedValues);
                } elseif ($this->isRadioGroup($group)) {
                    $data[$pdfField] = $this->handleRadioGroup($group, $option, $pdfField, $mappedValues);
                } else {
                    $data[$pdfField] = $this->handleMappedOption($pdfOptions, $mappedValues);
                }

            }
        }

        // === CONSENTIMIENTOS ===
        foreach (config('eoi.consentimientos') as $formKey => $pdfField) {
            $pdfOptions = $this->resolver->getOptions($this->layoutPath, $pdfField);
            $data[$pdfField] = !empty($participant[$formKey]) ? $this->getYesOption($pdfOptions) : 'Off';
        }

        // === LUGAR Y FECHA ===
        $data[config('eoi.lugar')] = isset($participant['lugar']) ? $this->capitalize($participant['lugar']) : '';
        $data[config('eoi.fecha')] = $participant['fecha'] ?? '';

        return $data;
    }

    // ========================== Helper Functions ==========================

    private function capitalize(string $value): string
    {
        return mb_convert_case(mb_strtolower($value, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }

    private function normalizeValue($value, string $group): ?string
    {
        if ($value === null)
            return null;

        // Radios / selects con múltiples opciones -> no tocar números ni textos
        if ($this->isRadioGroup($group)) {
            return trim((string) $value);
        }

        // Pares sí/no -> sí convertir
        $val = strtolower(trim((string) $value));

        return match ($val) {
            '1', 'sí', 'si', 'on' => 'sí',
            '0', '2', 'no' => 'no',
            '' => null,
            default => $value,
        };
    }

    private function normalizeOption($value): string
    {
        return strtolower(trim(html_entity_decode((string) $value)));
    }

    private function getYesOption(array $options): string
    {
        foreach ($options as $opt) {
            if ($opt !== 'Off')
                return html_entity_decode($opt, ENT_QUOTES, 'UTF-8');
        }
        return 'Sí';
    }

    private function isYesNoPair(string $group): bool
    {
        return in_array($group, [
            'ambito_rural',
            'politicas_sostenibilidad',
            'transformacion_digital',
            'mujer_responsable',
            'reside_en_localidad_menor_5000',
        ]);
    }

    private function isRadioGroup(string $group): bool
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

    private function handleYesNoPair(string $group, string $pdfField, array $mappedValues): string
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

    private function handleRadioGroup(string $group, string $option, string $pdfField, array $mappedValues): string
    {
        $value = $mappedValues[0] ?? null;
        if (!$value)
            return 'Off';

        // Normalizamos para comparar
        $normalizedValue = $this->normalizeOption($value);
        $normalizedOption = $this->normalizeOption($option);

        return $normalizedValue === $normalizedOption ? 'Sí' : 'Off';
    }

    private function handleMappedOption(array $pdfOptions, array $mappedValues): string
    {
        // Decodificar opciones PDF
        $decodedPdfOptions = array_map(fn($v) => html_entity_decode($v, ENT_QUOTES, 'UTF-8'), $pdfOptions);

        // Normalizamos para comparar
        $normalizedMapped = array_map([$this, 'normalizeOption'], $mappedValues);
        $normalizedPdf = array_map([$this, 'normalizeOption'], $decodedPdfOptions);

        // Recorremos las opciones del PDF
        foreach ($decodedPdfOptions as $i => $opt) {
            if ($opt === 'Off') {
                continue;
            }

            if (in_array($normalizedPdf[$i], $normalizedMapped, true)) {
                return $opt;
            }
        }

        return 'Off';
    }
}
