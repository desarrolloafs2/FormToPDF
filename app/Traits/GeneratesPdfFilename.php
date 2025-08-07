<?php

namespace App\Traits;

trait GeneratesPdfFilename
{
    public function generatePdfFilename(string $prefix = 'formulario'): string
    {
        $timestamp = now()->format('YmdHis');
        $random = mt_rand(1000, 9999);
        return "{$prefix}-{$timestamp}-{$random}.pdf";
    }
}
