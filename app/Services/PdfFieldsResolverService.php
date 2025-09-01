<?php
namespace App\Services;

use mikehaertl\pdftk\Pdf;

class PdfFieldsResolverService
{
    protected array $cache = [];

    public function getOptions(string $pdfPath, string $fieldName): array
    {
        if (!isset($this->cache[$pdfPath])) {
            $this->cache[$pdfPath] = $this->parseFields($pdfPath);
        }

        return $this->cache[$pdfPath][$fieldName] ?? [];
    }

    private function parseFields(string $pdfPath): array
    {
        $pdf = new Pdf($pdfPath, [
            'command' => env('PDFTK_PATH'),
            'useExec' => true,
        ]);

        $raw = $pdf->getDataFields();
        $lines = explode("\n", $raw);

        $fields = [];
        $currentField = null;

        foreach ($lines as $line) {
            if (str_starts_with($line, 'FieldName:')) {
                $currentField = trim(substr($line, 10));
                $fields[$currentField] = [];
            }
            if ($currentField && str_starts_with($line, 'FieldStateOption:')) {
                $option = trim(substr($line, 17));
                $fields[$currentField][] = $option;
            }
        }

        return $fields;
    }
}
