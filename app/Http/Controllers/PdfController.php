<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParticipantRequest;
use App\Services\CompanyService;
use App\Services\FormDataFormatterService;
use App\Services\ImageManagerService;
use App\Services\PdfGeneratorService;
use App\Services\SharepointUploaderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class PdfController extends Controller
{
    public function generate(
        StoreParticipantRequest $request,
        PdfGeneratorService $pdfService
    ): RedirectResponse {
        $participant = $request->validated();
        $companyInfo = null;

        if (!empty($participant['cif']) && !empty($participant['company'])) {
            $companyInfo = CompanyService::getCompanyInfo($participant['cif'], $participant['company']);
        }

        $formData = FormDataFormatterService::format($participant, $companyInfo);
        $generatedPdfName = $pdfService->generateFilledPdf($formData);

        if (!$generatedPdfName) {
            Log::error('Error al generar el PDF relleno', [
                'participant' => $participant,
                'formData' => $formData,
            ]);
            return $this->errorRedirect();
        }

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
            70,
            150,
            90,
            3
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

        if (!app()->environment('local')) {
            try {
                SharepointUploaderService::uploadPdf(
                    $signedPdfName,
                    $participant['nif'],
                    $participant['name'],
                    $participant['firstSurname'],
                    'MATRICULAS WEB/SEPE'
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
        // $pdfService->deletePdf('signed', $signedPdfName);
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
