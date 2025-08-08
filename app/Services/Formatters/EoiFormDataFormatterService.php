<?php

namespace App\Services\Formatters;

use Carbon\Carbon;
use App\Services\Contracts\PdfFormFormatterInterface;
use Log;

class EoiFormDataFormatterService implements PdfFormFormatterInterface
{
    public function format(array $participant, ?array $companyInfo = null): array
    {
        $data = [];

        // DATOS PERSONALES
        $data['Cuadro de texto 1_4'] = $participant['firstSurname'] ?? '';
        $data['Cuadro de texto 1'] = $participant['apellido2'] ?? '';
        $data['Cuadro de texto 1_2'] = $participant['name'] ?? '';
        $data['Cuadro de lista 1'] = $participant['tipo_documento'] ?? '';
        $data['Cuadro de texto 1_3'] = $participant['nif'] ?? '';
        $data['Cuadro de lista 1_2'] = $participant['sexo'] ?? '';
        $data['Campo de fecha 1'] = $participant['fecha_nacimiento'] ?? '';

        $data['Cuadro de texto 1_7'] = $participant['direccion'] ?? '';
        $data['Cuadro de texto 1_5'] = $participant['ciudad'] ?? '';
        $data['Cuadro de texto 1_6'] = $participant['codigo_postal'] ?? '';

        $data['Cuadro de lista 1_3'] = $participant['provincia'] ?? '';
        $data['Cuadro de lista 1_4'] = $participant['ccaa'] ?? '';
        $data['Campo num#C3#A9rico 1'] = $participant['telefono'] ?? '';
        $data['Cuadro de texto 1_8'] = $participant['email'] ?? '';

        // RESIDE EN LOCALIDAD < 5000
        $data['Botón de opción 1'] = $participant['reside_en_localidad_menor_5000'] ?? 'Off';

        // DISCAPACIDAD
        $data['Botón de opción 2'] = $participant['discapacidad'] ?? 'Off';

        // NIVEL DE ESTUDIOS
        $data['Cuadro de lista 1_5'] = $participant['nivel_estudios'] ?? '';

        // TITULACIÓN
        $data['Cuadro de texto 1_9'] = $participant['titulacion'] ?? '';

        // SITUACIÓN ACTUAL (radio)
        $data['Botón de opción 3'] = $this->isChecked($participant, 'situacion_actual', 'Directivo en una pyme');

        // EMPRESA
        $data['Cuadro de texto 1_10'] = $participant['empresa'] ?? '';
        $data['Cuadro de texto 1_11'] = $participant['nif_empresa'] ?? '';
        $data['Cuadro de lista 1_6'] = $participant['actividad_empresa'] ?? '';
        $data['Cuadro de lista 1_7'] = $participant['tamano_empresa'] ?? '';
        $data['Cuadro de lista 1_8'] = $participant['province'] ?? '';
        $data['Cuadro de lista 1_9'] = $participant['ccaa_empresa'] ?? '';
        $data['Cuadro de lista 1_10'] = $participant['antiguedad_empresa'] ?? '';
        $data['Cuadro de lista 1_11'] = $participant['facturacion'] ?? '';

        // EMPRESA – PREGUNTAS ESPECIALES (radios)
        $data['Botón de opción 4'] = $this->isChecked($participant, 'ambito_rural');
        $data['Botón de opción 5'] = $this->isChecked($participant, 'politicas_sostenibilidad');
        $data['Botón de opción 6'] = $this->isChecked($participant, 'transformacion_digital');
        $data['Botón de opción 7'] = $this->isChecked($participant, 'mujer_responsable');

        $data['Cuadro de lista 1_12'] = $participant['porcentaje_mujeres'] ?? '';

        // CONSENTIMIENTOS (checkboxes)
        $data['Casilla 1'] = $this->checkIfYes($participant, 'trabaja_en_pyme');
        $data['Casilla 1_2'] = $this->checkIfYes($participant, 'info_veraz');
        $data['Casilla 1_3'] = $this->checkIfYes($participant, 'no_duplicado');
        $data['Casilla 1_4'] = $this->checkIfYes($participant, 'sin_conflicto');
        $data['Casilla 1_5'] = $this->checkIfYes($participant, 'autorizo_datos');
        $data['Casilla 1_6'] = $this->checkIfYes($participant, 'autorizo_discapacidad');
        $data['Casilla 1_7'] = $this->checkIfYes($participant, 'condiciones');

        // FECHA Y LUGAR
        $data['Cuadro de texto 1_12'] = $participant['lugar'] ?? '';


        // Día, mes, año en los cuadros de lista
        try {
            if (!empty($participant['fecha'])) {
                $fecha = Carbon::parse($participant['fecha']);
                $data['a'] = $fecha->format('d');
                $data['de'] = ucfirst($fecha->translatedFormat('F'));
            }
        } catch (\Exception $e) {
            Log::error('Error parsing date: ' . $e->getMessage());
        }

        return $data;
    }

    private function isChecked(array $data, string $field, string $expected = 'Sí'): string
    {
        return ($data[$field] ?? '') === $expected ? 'Sí' : '';
    }

    private function setRadioGroup(array $participant, string $fieldName, string $pdfYes, string $pdfNo): array
    {
        $value = $participant[$fieldName] ?? null;

        return [
            $pdfYes => $value === '1' ? '1' : 'Off',
            $pdfNo => $value === '2' ? '2' : 'Off',
        ];
    }

    private function checkIfYes(array $participant, string $field): string
    {
        return !empty($participant[$field]) ? 'Yes' : 'Off';
    }

}
