<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use mikehaertl\pdftk\Pdf;
use FPDF;

class PdfGeneratorService
{
    protected string $layoutPath;
    protected string $generatedPath;
    protected string $signedPath;
    protected string $imagePath;

    public function __construct()
    {
        $this->layoutPath = storage_path('app/' . config('pdf.layout_path'));
        $this->generatedPath = storage_path('app/' . config('pdf.generated_path'));
        $this->signedPath = storage_path('app/' . config('pdf.signed_path'));
        $this->imagePath = storage_path('app/' . config('pdf.image_path'));
    }

    public function generateFilledPdf(array $data): ?string
    {
        if (!file_exists($this->layoutPath)) {
            Log::error("PDF layout not found at: {$this->layoutPath}");
            return null;
        }

        $fileName = 'annex1-' . now()->format('YmdHis') . '-' . mt_rand(1000, 9999) . '.pdf';
        $outputPath = $this->generatedPath . $fileName;

        $pdf = new Pdf($this->layoutPath, [
            'command' => env('PDFTK_PATH'),
            'useExec' => true,
        ]);

        $result = $pdf->fillForm($data)->needAppearances()->saveAs($outputPath);

        if ($result === false) {
            Log::error("PDF generation failed: " . $pdf->getError());
            return null;
        }

        return $fileName;
    }

    public function addSignatureToPdf(
        string $pdfName,
        string $signatureImageName,
        float $x,
        float $y,
        float $width,
        int $pageToSign = 1
    ): ?string {
        $inputPdfPath = $this->generatedPath . $pdfName;
        $outputPdfName = 'signed-' . $pdfName;
        $outputPdfPath = $this->signedPath . $outputPdfName;
        $imagePath = $this->imagePath . $signatureImageName;
        $overlayAbsolute = storage_path('app/pdf/generated/overlay-' . Str::uuid() . '.pdf');

        $pdftkPath = env('PDFTK_PATH', 'C:\Program Files (x86)\PDFtk Server\bin\pdftk.exe');
        Log::info("Trying pdftk with path: $pdftkPath");

        if (!file_exists($inputPdfPath)) {
            Log::error("Input PDF not found: $inputPdfPath");
            return null;
        }

        if (!file_exists($imagePath)) {
            Log::error("Signature image not found: $imagePath");
            return null;
        }

        if (!is_readable($inputPdfPath)) {
            Log::error("El archivo no es legible por el proceso PHP: $inputPdfPath");
            return null;
        }

        try {
            // Lee datos del PDF con path correcto
            $pdfReader = new Pdf($inputPdfPath, [
                'command' => $pdftkPath,
                'useExec' => true,
            ]);
            $data = $pdfReader->getData();

            if (!$data) {
                Log::error("No se pudo obtener metadata del PDF: " . $pdfReader->getError());
                return null;
            }

            // Determina la cantidad de páginas
            if (preg_match('/NumberOfPages:\s+(\d+)/', $data, $matches)) {
                $pageCount = (int) $matches[1];
            } else {
                Log::error("No se pudo determinar el número de páginas del PDF.");
                return null;
            }

            // Crea overlay
            $overlay = new FPDF('P', 'mm', 'A4');
            for ($i = 1; $i <= $pageCount; $i++) {
                $overlay->AddPage();
                if ($i === $pageToSign) {
                    $overlay->Image($imagePath, $x, $y, $width);
                }
            }
            $overlay->Output('F', $overlayAbsolute);

            // Ejecuta multistamp con pdftk correctamente configurado
            $pdf = new Pdf($inputPdfPath, [
                'command' => $pdftkPath,
                'useExec' => true,
            ]);
            $success = $pdf->multiStamp($overlayAbsolute)->saveAs($outputPdfPath);

            if (!$success) {
                Log::error("Error al hacer multiStamp: " . $pdf->getError());
                return null;
            }

            return $outputPdfName;
        } catch (\Throwable $e) {
            Log::error("Failed to sign PDF: {$e->getMessage()}");
            if (app()->environment('local')) {
                report($e);
            }
            return null;
        } finally {
            if (file_exists($overlayAbsolute)) {
                unlink($overlayAbsolute);
            }
        }
    }


    public function deletePdf(string $type, string $name): void
    {
        $path = "pdf/{$type}/{$name}";

        if (Storage::exists($path)) {
            Storage::delete($path);
        } else {
            Log::warning("Attempted to delete non-existing PDF: $path");
        }
    }
}
