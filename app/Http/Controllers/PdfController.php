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

class PdfController extends Controller
{
    public function generate(StoreParticipantRequest $request): RedirectResponse
    {
        $participant = $request->validated();

        $companyInfo = null;

        if (!empty($participant['cif']) && !empty($participant['company'])) $companyInfo = CompanyService::getCompanyInfo($participant['cif'], $participant['company']);

        $formData = FormDataFormatterService::format($participant, $companyInfo);

        $generatedPdf = PdfGeneratorService::generateFilledPdf($formData);

        $signature = ImageManagerService::uploadImage($participant['signature']);

        $signedPdf = PdfGeneratorService::addSignatureToPdf($generatedPdf, $signature, 70, 150, 90, 3);

        if ($signedPdf) {
            SharepointUploaderService::uploadPdf(
                $signedPdf,
                $participant['nif'],
                $participant['name'],
                $participant['firstSurname'],
                'MATRICULAS WEB/SEPE'
            );
            PdfGeneratorService::deletePdf('signed', $signedPdf);
            $response = redirect('https://grupoafs.com/gracias-por-preinscribirte/');
        }else{
            $response =  redirect()->back()->withErrors([
                    'general' => 'Ha ocurrido un error inesperado. Por favor, inténtelo de nuevo más tarde. Si el problema persiste, póngase en contacto con nosotros y estaremos encantados de asistirle.'
            ])->withInput();
        }

        if($generatedPdf) PdfGeneratorService::deletePdf('generated', $generatedPdf);
        if($signature) ImageManagerService::deleteImage($signature);

        return $response;
    }
}
