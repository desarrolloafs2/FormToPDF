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
        $data['Cuadro de texto 1'] = $participant['apellido1'] ?? '';
        $data['Cuadro de texto 1_2'] = $participant['apellido2'] ?? '';
        $data['Cuadro de lista 1'] = $participant['tipo_documento'] ?? '';
        $data['Cuadro de texto 1_3'] = $participant['documento'] ?? '';
        $data['Cuadro de lista 1_2'] = $participant['sexo'] ?? '';
        $data['Campo de fecha 1'] = $participant['fecha_nacimiento'] ?? '';
        $data['Cuadro de texto 1_4'] = $participant['direccion'] ?? '';
        $data['Cuadro de texto 1_5'] = $participant['ciudad'] ?? '';
        $data['Cuadro de texto 1_6'] = $participant['codigo_postal'] ?? '';
        $data['Cuadro de texto 1_7'] = $participant['provincia'] ?? '';
        $data['Cuadro de lista 1_3'] = $participant['ccaa'] ?? '';
        $data['Cuadro de lista 1_4'] = $participant['telefono'] ?? '';
        $data['Campo numérico 1'] = $participant['email'] ?? '';
        $data['Cuadro de texto 1_8'] = $participant['nivel_estudios'] ?? '';

        // RESIDENCIA (radio)
        $data['Botón de opción 1'] = $this->isChecked($participant, 'reside_en_localidad_menor_5000');
        $data['Botón de opción 2'] = $this->isChecked($participant, 'reside_en_localidad_menor_5000', 'No');

        // DISCAPACIDAD
        $data['Cuadro de lista 1_5'] = $participant['discapacidad'] ?? '';

        // TITULACIÓN
        $data['Cuadro de texto 1_9'] = $participant['titulacion'] ?? '';

        // SITUACIÓN ACTUAL (radio)
        $data['Botón de opción 3'] = $this->isChecked($participant, 'situacion_actual', 'Directivo en una pyme');

        // EMPRESA
        $data['Cuadro de texto 1_10'] = $participant['empresa'] ?? '';
        $data['Cuadro de texto 1_11'] = $participant['nif_empresa'] ?? '';
        $data['Cuadro de lista 1_6'] = $participant['actividad_empresa'] ?? '';
        $data['Cuadro de lista 1_7'] = $participant['tamano_empresa'] ?? '';
        $data['Cuadro de lista 1_8'] = $participant['provincia_empresa'] ?? '';
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
        $data['Casilla 1'] = $this->isChecked($participant, 'trabaja_en_pyme', 'on');
        $data['Casilla 1_2'] = $this->isChecked($participant, 'info_veraz', 'on');
        $data['Casilla 1_3'] = $this->isChecked($participant, 'no_duplicado', 'on');
        $data['Casilla 1_4'] = $this->isChecked($participant, 'sin_conflicto', 'on');
        $data['Casilla 1_5'] = $this->isChecked($participant, 'autorizo_datos', 'on');
        $data['Casilla 1_6'] = $this->isChecked($participant, 'autorizo_discapacidad', 'on');
        $data['Casilla 1_7'] = $this->isChecked($participant, 'condiciones', 'on');

        // FECHA Y LUGAR
        $data['Cuadro de texto 1_12'] = $participant['lugar'] ?? '';

        try {
            if (!empty($participant['fecha'])) {
                $fecha = Carbon::parse($participant['fecha']);
                $data['a'] = $fecha->format('d');
                $data['de'] = ucfirst($fecha->translatedFormat('F'));
            }
        } catch (\Exception $e) {
            Log::error('Error parsing date: '. $e->getMessage());
        }

        return $data;
    }

    private function isChecked(array $data, string $field, string $expected = 'Sí'): string
    {
        return ($data[$field] ?? '') === $expected ? 'Sí' : '';
    }
}
