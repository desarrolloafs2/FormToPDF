<?php

namespace App\Services\Formatters;

use Carbon\Carbon;
use App\Services\Contracts\PdfFormFormatterInterface;
use Log;

class MecFormDataFormatterService implements PdfFormFormatterInterface
{
    public function format(array $participant, ?array $companyInfo = null): array
    {
        $data = [];

        //---  Datos personales ---
        $nombreCompleto = trim(
            ($participant['name'] ?? '') . ' ' .
            ($participant['firstSurname'] ?? '') . ' ' .
            ($participant['apellido2'] ?? '')
        );
        $data['nombre_completo'] = preg_replace('/\s+/', ' ', $nombreCompleto);
        $data['nif'] = strtoupper(trim($participant['nif'] ?? ''));
        $data['direccion'] = trim($participant['direccion'] ?? '');
        $data['tipo_via'] = trim($participant['tipo_via'] ?? '');
        $data['localidad'] = trim($participant['localidad'] ?? '');
        $data['CP'] = trim($participant['codigo_postal'] ?? '');
        $data['birthdate'] = trim($participant['birthdate'] ?? '');
        $data['provincia'] = trim($participant['provincia'] ?? '');
        $data['telefono_movil'] = preg_replace('/\s+/', '', $participant['telefono'] ?? '');
        $data['telefono_fijo'] = preg_replace('/\s+/', '', $participant['telefono_fijo'] ?? '');
        $data['email'] = strtolower(trim($participant['email'] ?? ''));
        $data['carnet'] = ($participant['carnet'] ?? '') === 'si' ? 'Sí' : 'No';
        $data['carnet_tipos'] = trim($participant['carnet_tipos'] ?? '');

        // ---Datos del representante ---
        $data['nif_representante'] = strtoupper(trim($participant['nif_rep'] ?? ''));
        $data['nombre_representante'] = trim($participant['name_rep'] ?? '');
        $data['apellido1_representante'] = trim($participant['firstSurname_rep'] ?? '');
        $data['apellido2_representante'] = trim($participant['apellido2_rep'] ?? '');
        $data['direccion_representante'] = trim($participant['direccion_rep'] ?? '');
        $data['provincia_representante'] = trim($participant['provincia_rep'] ?? '');
        $data['CP_representante'] = trim($participant['CP_rep'] ?? '');
        $data['poblacion_representante'] = trim($participant['poblacion_rep'] ?? '');
        $data['telefono_representante'] = preg_replace('/\s+/', '', $participant['telefono_fijo_rep'] ?? '');
        $data['movil_representante'] = preg_replace('/\s+/', '', $participant['telefono_movil_rep'] ?? '');
        $data['email_representante'] = strtolower(trim($participant['email_rep'] ?? ''));
        $data['horario_llamadas'] = trim($participant['horario_llamadas'] ?? '');
        // --- Situación Laboral ---
        $data['trabajador_desempleado'] = ($participant['situacion_laboral'] ?? '') === 'desempleado' ? 'Sí' : 'No';
        $data['trabajador_ocupado'] = ($participant['situacion_laboral'] ?? '') === 'ocupado' ? 'Sí' : 'No';

        // Campos desempleado
        $data['oficina_empleo'] = trim($participant['oficina_empleo'] ?? '');
        $data['fecha_inscripcion'] = trim($participant['fecha_inscripcion'] ?? '');
        $data['situacion_desempleado'] = isset($participant['situacion_desempleado'])
            ? (config('options.situacion_desempleado')[$participant['situacion_desempleado']] ?? '')
            : '';

        // Campos ocupado
        $data['sector'] = trim($participant['sector'] ?? '');
        $data['cif'] = trim($participant['cif'] ?? '');
        $data['razon_social'] = trim($participant['razon_social'] ?? '');
        $data['domicilio_trabajo'] = trim($participant['domicilio_trabajo'] ?? '');
        $data['localidad_trabajo'] = trim($participant['localidad_trabajo'] ?? '');
        $data['cp_trabajo'] = trim($participant['cp_trabajo'] ?? '');
        $data['regimen_cotizacion'] = trim($participant['regimen_cotizacion'] ?? '');

        // Categorías
        foreach (array_keys(config('options.categorias')) as $key) {
            $data['categoria_' . $key] = !empty($participant[$key]) ? 'Sí' : 'No';
        }
        $data['categoria'] = isset($participant['categoria'])
            ? (config('options.categorias')[$participant['categoria']] ?? '')
            : '';


        // ---Datos Académicos---
        $data['nivel_academico'] = trim($participant['nivel_academico'] ?? '');
        $data['especialidad'] = trim($participant['especialidad'] ?? '');

        // --- Idiomas ---
        $idiomas = [
            'ingles' => ['', 'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'BASICO', 'MEDIO', 'AVANZADO'],
            'frances' => ['', 'A1_2', 'A2_2', 'B1_2', 'B2_2', 'C1_2', 'C2_2', 'BASICO_2', 'MEDIO_2', 'AVANZADO_2'],
            'otro' => ['', 'A13', 'B1_3', 'B2_3', 'C1_3', 'C2_3', 'BASICO_3', 'MEDIO_3', 'AVANZADO_3']
        ];
        foreach ($idiomas as $lang => $niveles) {
            $data[strtoupper($lang)] = trim($participant[$lang] ?? '');
            foreach ($niveles as $nivel) {
                if ($nivel === '')
                    continue;
                $data[$nivel] = trim($participant[$nivel] ?? '');
            }
        }
        $data['otro_idioma'] = trim($participant['otro_idioma'] ?? '');

        // --- Formación Profesional ---
        $data['curso'] = isset($participant['curso']) ? implode(', ', array_filter($participant['curso'])) : '';
        $data['anio_formacion'] = isset($participant['anio']) ? implode(', ', array_filter($participant['anio'])) : '';
        $data['duracion'] = isset($participant['duracion']) ? implode(', ', array_filter($participant['duracion'])) : '';
        $data['centro'] = isset($participant['centro']) ? implode(', ', array_filter($participant['centro'])) : '';
        $data['otro_curso'] = isset($participant['otro_curso']) ? ucfirst($participant['otro_curso']) : '';
        $data['otro_curso_text'] = isset($participant['otro_curso_text']) ? trim($participant['otro_curso_text']) : '';


        // --- Experiencia Profesional ---
        $data['puesto'] = trim($participant['puesto'] ?? '');
        $data['funciones'] = trim($participant['puesto'] ?? '');
        $data['empresa'] = trim($participant['puesto'] ?? '');
        $data['duracion_trabajo'] = trim($participant['puesto'] ?? '');
        $data['sector_trabajo'] = trim($participant['puesto'] ?? '');

        // --- Motivos de participación ---


        return $data;
    }

    private function isChecked(array $data, string $field, string $expected = 'Sí'): string
    {
        return ($data[$field] ?? '') === $expected ? 'Sí' : '';
    }

}