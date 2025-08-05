<?php

namespace App\Services;

use App\Models\Company as CompanyModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CompanyService
{
    public static function getCompanyInfo(string $cif, string $name): ?array
    {
        $existing = CompanyModel::where('cif', $cif)->first();

        if ($existing && $existing->updated_at > now()->subDays(90)) return $existing->toArray();

        $token = self::getToken();

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'authorization' => "Bearer {$token}"
        ])->get(env('E_INFORMA_BASE_PATH') . "/companies/{$cif}/report");

        if (!$response->successful()) return $existing ? $existing->toArray() : null;

        $data = $response->json();

        $record = [
            'cif' => $data['identificativo'] ?? $cif,
            'name' => $data['denominacion'] ?? $name,
            'address' => $data['domicilioSocial'] ?? null,
            'city' => $data['localidad'] ?? null,
            'legal_form' => $data['formaJuridica'] ?? null,
            'cnae' => $data['cnae'] ?? null,
            'last_balance_date' => $data['fechaUltimoBalance'] ?? null,
            'status' => $data['situacion'] ?? null,
            'phone' => $data['telefono'][0] ?? null,
            'website' => $data['web'][0] ?? null,
            'email' => $data['email'] ?? null,
            'ceo_name' => $data['cargoPrincipal'] ?? null,
            'ceo_position' => $data['cargoPrincipalPuesto'] ?? null,
            'capital' => $data['capitalSocial'] ?? null,
            'sales' => $data['ventas'] ?? null,
            'sales_year' => $data['anioVentas'] ?? null,
            'employees' => $data['empleados'] ?? null,
            'founded_at' => $data['fechaConstitucion'] ?? null,
        ];

        $company = CompanyModel::updateOrCreate(['cif' => $cif], $record);

        return $company->toArray();
    }

    private static function getToken(): string
    {
        return Cache::remember('einforma_token', 3500, function () {
            $response = Http::asForm()->withHeaders([
                'accept' => 'application/json',
            ])->post(env('E_INFORMA_BASE_PATH') . '/oauth/token', [
                'client_id' => env('E_INFORMA_CLIENT_ID'),
                'client_secret' => env('E_INFORMA_CLIENT_SECRET'),
                'grant_type' => 'client_credentials',
                'scope' => 'buscar:consultar:empresas',
            ]);

            return $response->json()['access_token'] ?? throw new \RuntimeException('No se pudo obtener el token');
        });
    }
}
