<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use mikehaertl\pdftk\Pdf;
use FPDF;

class PdfGeneratorService
{

    public static function generateFilledPdf(array $data): ?string
    {
        $fileName = 'annex1-' . date('YmdHis') . '-' . mt_rand(1000, 9999) . '.pdf';
        $pdfPath = storage_path('app/pdf/layouts/annex1.pdf');
        $outputPath = storage_path('app/pdf/generated/' . $fileName);

        $pdf = new Pdf($pdfPath, [
            'command' => env('PDFTK_PATH'),
            'useExec' => true,
        ]);

        $result = $pdf->fillForm($data)->needAppearances()->saveAs($outputPath);

        if ($result === false) {
            dd($pdf->getError());  
        }
        
        return $result ? $fileName : null;
    }

    public static function addSignatureToPdf(string $pdfName, string $signatureImageName, float $x, float $y, float $width, int $pageToSign = 1): ?string
    {
        $inputPdfPath = storage_path('app/pdf/generated/' . $pdfName);
        $outputPdfName = 'signed-' . $pdfName;
        $outputPdfPath = storage_path('app/pdf/signed/' . $outputPdfName);
        $imagePath = storage_path('app/image/' . $signatureImageName);

        $overlayRelative = 'pdf/generated/overlay-' . Str::uuid() . '.pdf';
        $overlayAbsolute = storage_path('app/' . $overlayRelative);

        try {
            $data = (new Pdf($inputPdfPath))->getData();
            if (preg_match('/NumberOfPages:\s+(\d+)/', $data, $matches))
                $pageCount = (int) $matches[1];
            else
                $pageCount = $pageToSign;

            $overlay = new Fpdf('P', 'mm', 'A4');
            for ($i = 1; $i <= $pageCount; $i++) {
                $overlay->AddPage();
                if ($i === $pageToSign)
                    $overlay->Image($imagePath, $x, $y, $width);
            }

            $overlay->Output('F', $overlayAbsolute);

            $pdf = new Pdf($inputPdfPath);
            $success = $pdf->multiStamp($overlayAbsolute)->saveAs($outputPdfPath);

            Storage::delete($overlayRelative);

            return $success ? $outputPdfName : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function deletePdf(string $type, string $name): void
    {
        Storage::delete('pdf/' . $type . '/' . $name);
    }
}
