<?php

namespace App\Services;

use Office365\Runtime\Auth\ClientCredential;
use Office365\SharePoint\ClientContext;
use Illuminate\Support\Str;

class SharepointUploaderService
{
    public static function uploadPdf(string $fileName, string $nif, string $name, string $firstSurname, string $sharepointFolder): void
    {
        $credentials = new ClientCredential(env('SHAREPOINT_ID'), env('SHAREPOINT_SECRET'));
        $ctx = (new ClientContext(env('SHAREPOINT_BASE_PATH')))->withCredentials($credentials);

        $pdfPath = storage_path('app/pdf/signed/' . $fileName);
        $pdfContent = file_get_contents($pdfPath);

        $fileSlug = Str::slug("{$nif}-{$name}-{$firstSurname}") . '.pdf';

        $folder = $ctx->getWeb()->getFolderByServerRelativeUrl('Documentos compartidos/'.$sharepointFolder);
        $folder->uploadFile($fileSlug, $pdfContent);
        $ctx->executeQuery();
    }
}
