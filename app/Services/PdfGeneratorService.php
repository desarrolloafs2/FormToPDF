<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use mikehaertl\pdftk\Pdf;
use FPDF;

use App\Traits\GeneratesPdfFilename;

class PdfGeneratorService
{
    protected string $layoutPath;
    protected string $uploadPath;
    protected string $generatedPath;
    protected string $signedPath;
    protected string $imagePath;
    protected string $type;

    use GeneratesPdfFilename;

    public function __construct(string $type)
    {
        $types = config('pdf.types');

        if (!array_key_exists($type, $types)) {
            throw new \InvalidArgumentException("Tipo de formulario PDF inválido: {$type}");
        }

        $this->type = $type;

        $this->layoutPath = storage_path('app/' . $types[$type]['layout']);
        $this->uploadPath = storage_path('app/' . $types[$type]['upload_path']);
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

        $fileName = $this->generatePdfFilename($this->type);
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
            $pdfReader = new Pdf($inputPdfPath, [
                'command' => $pdftkPath,
                'useExec' => true,
            ]);
            $data = $pdfReader->getData();

            if (!$data || !preg_match('/NumberOfPages:\s+(\d+)/', $data, $matches)) {
                Log::error("No se pudo determinar el número de páginas del PDF.");
                return null;
            }

            $pageCount = (int) $matches[1];

            $overlay = new FPDF('P', 'mm', 'A4');
            for ($i = 1; $i <= $pageCount; $i++) {
                $overlay->AddPage();
                if ($i === $pageToSign) {
                    $overlay->Image($imagePath, $x, $y, $width);
                }
            }

            $overlay->Output('F', $overlayAbsolute);

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
