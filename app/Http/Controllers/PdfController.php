<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParticipantRequest;
use App\Services\CompanyService;
use App\Services\FormDataFormatterService;
use App\Services\ImageManagerService;
use App\Services\PdfGeneratorService;
use App\Services\SharepointUploaderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class PdfController extends Controller
{
    public function generate(StoreParticipantRequest $request, string $type): RedirectResponse
    {
        // Validamos que el tipo esté registrado en el config/pdf.php
        if (!array_key_exists($type, config('pdf.types'))) {
            abort(404, 'Tipo de formulario no válido');
        }

        // Creamos manualmente el servicio con el tipo
        $pdfService = new PdfGeneratorService($type);

        // Validación y recopilación de datos
        $participant = $request->validated();
        $companyInfo = null;

        if (!empty($participant['cif']) && !empty($participant['company'])) {
            $companyInfo = CompanyService::getCompanyInfo($participant['cif'], $participant['company']);
        }

        $formData = FormDataFormatterService::format($participant, $companyInfo);
        $generatedPdfName = $pdfService->generateFilledPdf($formData, $type);

        if (!$generatedPdfName) {
            Log::error('Error al generar el PDF relleno', [
                'participant' => $participant,
                'formData' => $formData,
            ]);
            return $this->errorRedirect();
        }

        // Firma
        $signatureImageName = ImageManagerService::uploadImage($participant['signature']);
        if (!$signatureImageName) {
            Log::error('Error al subir la imagen de firma', [
                'participant' => $participant,
            ]);
            $pdfService->deletePdf('generated', $generatedPdfName);
            return $this->errorRedirect();
        }

        $signedPdfName = $pdfService->addSignatureToPdf(
            $generatedPdfName,
            $signatureImageName,
            70, // x
            150, // y
            90, // width
            3 // page
        );

        if (!$signedPdfName) {
            Log::error('Error al firmar el PDF', [
                'generatedPdf' => $generatedPdfName,
                'signatureImage' => $signatureImageName,
            ]);
            $pdfService->deletePdf('generated', $generatedPdfName);
            ImageManagerService::deleteImage($signatureImageName);
            return $this->errorRedirect();
        }

        // Subida a SharePoint si no es local
        if (!app()->environment('local')) {
            try {
                SharepointUploaderService::uploadPdf(
                    $signedPdfName,
                    $participant['nif'],
                    $participant['name'],
                    $participant['firstSurname'],
                    config("pdf.types.$type.upload_path") // Ruta dinámica
                );
            } catch (\Throwable $e) {
                Log::error('Error al subir el PDF firmado a SharePoint', [
                    'pdf' => $signedPdfName,
                    'exception' => $e->getMessage(),
                ]);
            }
        } else {
            Log::info("Subida a SharePoint simulada: {$signedPdfName} no se sube en entorno local.");
        }

        // Limpiar archivos temporales
        $pdfService->deletePdf('generated', $generatedPdfName);
        ImageManagerService::deleteImage($signatureImageName);

        return redirect('https://grupoafs.com/gracias-por-preinscribirte/');
    }

    protected function errorRedirect(): RedirectResponse
    {
        return redirect()
            ->back()
            ->withErrors([
                'general' => 'Ha ocurrido un error inesperado. Por favor, inténtelo de nuevo más tarde. Si el problema persiste, póngase en contacto con nosotros y estaremos encantados de asistirle.'
            ])
            ->withInput();
    }
}
