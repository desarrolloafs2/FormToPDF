<?php
namespace App\Services\Contracts;

interface PdfFormFormatterInterface
{
    public function format(array $participant, ?array $companyInfo = null): array;
}
