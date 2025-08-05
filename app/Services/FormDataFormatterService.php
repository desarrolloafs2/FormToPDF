<?php

namespace App\Services;

use Carbon\Carbon;

class FormDataFormatterService
{
    public static function format(array $participant, ?array $companyInfo): array
    {
        $data = [];

        $data['Nombre'] = $participant['name'];
        $data['1 er Apellido'] = $participant['firstSurname'];
        $data['2  Apellido'] = $participant['secondSurname'];
        $data['NIF'] = $participant['nif'];
        $data['Género'] = $participant['gender'];
        $data['Dirección'] = $participant['address'];
        $data['Localidad'] = $participant['locality'];
        $data['CP'] = $participant['postalCode'];
        $data['Tfno'] = $participant['phone'];
        $data['Email'] = $participant['email'];

        $ssnumber = $participant['ssnumber'];
        $data['N de afiliación a la Seguridad Social'] = substr($ssnumber, 0, 2);
        $data['undefined'] = substr($ssnumber, 2);

        [$year, $month, $day] = explode('-', $participant['birthdate']);
        $data['AÑO'] = substr($year, 2);
        $data['MES'] = $month;
        $data['DÍA'] = $day;

        $data[$participant['disability'] > 0 ? 'Check Box1' : 'Check Box2'] = 'Sí';

        $studyMap = [
            23 => 'Check Box40', 24 => 'Check Box39', 32 => 'Check Box38',
            33 => 'Check Box37', 34 => 'Check Box36', 38 => 'Check Box35',
            41 => 'Check Box34', 51 => 'Check Box33', 61 => 'Check Box32',
            62 => 'Check Box31', 71 => 'Check Box30', 72 => 'Check Box29',
            73 => 'Check Box28', 74 => 'Check Box27', 81 => 'Check Box26'
        ];
        $data[$studyMap[$participant['studyLevel']] ?? 'Check Box1'] = 'Sí';

        $groupMap = array_combine(range(1, 11), range(41, 51));
        $group = (int) $participant['contributionGroup'];

        if (isset($groupMap[$group])) {
            $data['Check Box' . $groupMap[$group]] = 'Sí';
        }

        $qualMap = ['PR' => 52, 'A1' => 53, 'A2' => 54, 'B1' => 55, 'B2' => 56, 'C1' => 57, 'C2' => 58, 'ZZ' => 59];
        if (isset($qualMap[$participant['otherQualification']])) {
            $data['Check Box' . $qualMap[$participant['otherQualification']]] = 'Sí';
            if ($participant['otherQualification'] === 'ZZ') {
                $data['ZZ  Otra Especificar'] = $participant['zzOtherText'];
            } else {
                $data['ZZ  Otra Especificar'] = '';
            }
        }

        $catMap = [
            'directivo' => 16, 'mando_intermedio' => 17, 'tecnico' => 18,
            'trabajador_cualificado' => 19, 'baja_cualificacion' => 20
        ];
        if (isset($catMap[$participant['professionalCategory']])) {
            $data['Check Box' . $catMap[$participant['professionalCategory']]] = 'Sí';
        }

        $funcMap = [
            'direccion' => 21, 'administracion' => 22, 'comercial' => 23,
            'mantenimiento' => 24, 'produccion' => 25
        ];
        if (!empty($participant['functionalArea']) && isset($funcMap[$participant['functionalArea']])) {
            $data['Check Box' . $funcMap[$participant['functionalArea']]] = 'Sí';
        }

        $cno = str_split($participant['cno']);
        $data['CNO 11'] = $cno[0] ?? '';
        $data['Text13'] = $cno[1] ?? '';
        $data['Text14'] = $cno[2] ?? '';
        $data['Text15'] = $cno[3] ?? '';

        $status = $participant['participantStatus'];
        switch ($status) {
            case 'ocupado':
                $data['OCUPADO'] = 'Sí';
                $data['Ocupado Consignar Código 1'] = $participant['employmentRegime'];
                break;
            case 'dsp':
                $data['DESEMPLEADO'] = 'Sí';
                break;
            case 'dspld':
                $data['DSPLD'] = 'Sí';
                break;
            case 'cpn':
                $data['CPN'] = 'Sí';
                break;
        }
        if ($status !== 'ocupado') {
            $data['Ocupado Consignar Código 1'] = '';
        }

        $data['Fecha en'] = $participant['province'];

        Carbon::setLocale('es');
        $now = Carbon::now();
        $data['a'] = $now->day;
        $data['de'] = ucfirst($now->translatedFormat('F'));

        if ($companyInfo) {
            $postal = self::extractPostal($companyInfo['city']);
            $employees = (int)$companyInfo['employees'];
            $cnaeCode = self::extractCnae($companyInfo['cnae']);

            $data['ENTIDAD DONDE TRABAJA ACTUALMENTE'] = $companyInfo['name'];
            $data['Razón Social'] = $companyInfo['name'];
            $data['C I F'] = $participant['cif'];
            $data['Domicilio del Centro de Trabajo'] = $companyInfo['address'];
            $data['CP_2'] = $postal[0];
            $data['Localidad_2'] = $postal[1];

            $data['SECTOR DE ACTIVIDAD'] = $cnaeCode ?? $companyInfo['cnae'];
            $data['CONVENIO DE APLICACIÓN'] = $cnaeCode ? self::getEpsByCnae($cnaeCode) : '';

            $data[self::mapEmployeeSize($employees)] = 'Sí';
        } else {
            if (!empty($participant['cif']) && !empty($participant['company'])){
                $data['ENTIDAD DONDE TRABAJA ACTUALMENTE'] = $participant['company'];
                $data['Razón Social'] = $participant['company'];
                $data['C I F'] = $participant['cif'];
            }else{
                $data['ENTIDAD DONDE TRABAJA ACTUALMENTE'] = '';
                $data['Razón Social'] = '';
                $data['C I F'] = '';
            }
            $data['SECTOR DE ACTIVIDAD'] = '';
            $data['CONVENIO DE APLICACIÓN'] = '';
            $data['Domicilio del Centro de Trabajo'] = '';
            $data['CP_2'] = '';
            $data['Localidad_2'] = '';
        }

        return $data;
    }

    private static function extractPostal(string $text): array
    {
        preg_match('/\\b(\\d{5})\\b/', $text, $m);
        return isset($m[1]) ? [$m[1], trim(str_replace($m[1], '', $text))] : ['', $text];
    }

    private static function extractCnae(string $cnae): ?string
    {
        preg_match('/\\b(\\d{4})\\b/', $cnae, $m);
        return $m[1] ?? null;
    }

    private static function getEpsByCnae(string $cnae): string
    {
        static $map = null;
        if ($map === null) {
            $map = require storage_path('app/cnae_eps_map.php');
        }
        return $map[$cnae] ?? '';
    }

    private static function mapEmployeeSize(int $n): string
    {
        return match (true) {
            $n < 10 => 'INFERIOR A 10',
            $n <= 49 => '10 -49',
            $n <= 99 => '50 - 99',
            $n <= 249 => '100 - 249',
            default => '250 +'
        };
    }
}
