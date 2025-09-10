<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use App\Services\ImageManagerService;
use App\Services\PdfGeneratorService;
use App\Services\SharepointUploaderService;
use App\Services\Contracts\PdfFormFormatterInterface;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;


class PdfController extends Controller
{
    public function generate(FormRequest $request, PdfFormFormatterInterface $formatter, string $type): RedirectResponse
    {

        // Log de la request completa, excluyendo la firma si existe
        $requestData = $request->except('signature'); // excluimos la firma
        Log::info('[PdfController] Request recibida', $requestData);

        // Validamos que el tipo esté registrado en el config/pdf.php
        if (!array_key_exists($type, config('pdf.types'))) {
            abort(404, 'Tipo de formulario no válido');
        }
        $formRequestClass = config("forms.types.$type.request");

        // Creamos manualmente el servicio con el tipo
        $pdfService = new PdfGeneratorService($type);

        // Crea la instancia del FormRequest y ejecuta la validación
        $request = App::make($formRequestClass);
        $request->setContainer(app())->setRedirector(app('redirect'));
        $request->validateResolved();
        // Validación y recopilación de datos
        $participant = $request->validated();

        $companyInfo = null;
        if (!empty($participant['cif']) && !empty($participant['company'])) {
            $companyInfo = CompanyService::getCompanyInfo($participant['cif'], $participant['company']);
        }

        $formData = $formatter->format($participant, $companyInfo);
        $generatedPdfName = $pdfService->generateFilledPdf($formData);

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

        $coords = config("pdf.types.$type.signature_coords");

        $signedPdfName = $pdfService->addSignatureToPdf(
            $generatedPdfName,
            $signatureImageName,
            $coords['x'],
            $coords['y'],
            $coords['width'],
            null
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

        if (!App::environment(['local', 'testing'])) {
            try {
                SharepointUploaderService::uploadPdf(
                    $signedPdfName,
                    $participant['nif'],
                    $participant['name'],
                    $participant['firstSurname'],
                    config("pdf.types.$type.upload_path")
                );
            } catch (\Throwable $e) {
                Log::error('Error al subir el PDF firmado a SharePoint', [
                    'pdf' => $signedPdfName,
                    'exception' => $e->getMessage(),
                ]);
            }
        } else {
            Log::info('SharePoint upload skipped due to local/testing environment.', [
                'pdf' => $signedPdfName
            ]);
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
