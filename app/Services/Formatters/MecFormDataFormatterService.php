<?php

namespace App\Services\Formatters;

use Carbon\Carbon;
use App\Services\Contracts\PdfFormFormatterInterface;
use App\Services\Helpers\PdfFormHelperService;
use Log;

class MecFormDataFormatterService implements PdfFormFormatterInterface
{
    protected PdfFormHelperService $helper;

    public function __construct(PdfFormHelperService $helper)
    {
        $this->helper = $helper;
    }

    public function format(array $participant, ?array $companyInfo = null): array
    {
        // Clonar y eliminar la firma antes de log
        $participantLog = $participant;
        unset($participantLog['signature']); // o 'firma', según tu array

        Log::info('[MecFormDataFormatterService] - PARTICIPANT raw data (sin firma)', [
            'participant' => $participantLog
        ]);

        $data = [];

        // --- DATOS PERSONALES ---
        $nombreCompleto = trim(
            ($participant['name'] ?? '') . ' ' .
            ($participant['firstSurname'] ?? '') . ' ' .
            ($participant['apellido2'] ?? '')
        );
        $data['nombre_completo'] = $this->helper->capitalize(preg_replace('/\s+/', ' ', $nombreCompleto));
        $data['nif'] = strtoupper(trim($participant['nif'] ?? ''));
        $data['direccion'] = trim($participant['direccion'] ?? '');
        $data['tipo_via'] = trim($participant['tipo_via'] ?? '');
        $data['localidad'] = trim($participant['localidad'] ?? '');
        $data['CP'] = trim($participant['codigo_postal'] ?? '');
        $data['provincia'] = trim($participant['provincia'] ?? '');
        $data['telefono_movil'] = preg_replace('/\s+/', '', $participant['telefono'] ?? '');
        $data['telefono_fijo'] = preg_replace('/\s+/', '', $participant['telefono_fijo'] ?? '');
        $data['email'] = strtolower(trim($participant['email'] ?? ''));
        $data['carnet'] = $this->helper->handleRadioOption($participant['carnet'], 'si');
        $data['carnet_tipos'] = trim($participant['carnet_tipos'] ?? '');
        $data['birthdate'] = $this->helper->formatDate($participant['birthdate'] ?? null);

        // --- SEXO ---
        $sexo = strtoupper(trim($participant['sexo'] ?? ''));
        foreach (config('options.sexo') as $s) {
            $data['sexo_' . strtolower($s)] = $this->helper->handleRadioOption($sexo === $s ? 'On' : null);
        }

        // --- DATOS DEL REPRESENTANTE ---
        $data['nif_representante'] = strtoupper(trim($participant['nif_representante'] ?? ''));
        $data['nombre_representante'] = $this->helper->capitalize(trim($participant['name_representante'] ?? ''));
        $data['apellido1_representante'] = $this->helper->capitalize(trim($participant['firstSurname_representante'] ?? ''));
        $data['apellido2_representante'] = $this->helper->capitalize(trim($participant['apellido2_representante'] ?? ''));
        $data['direccion_representante'] = trim($participant['direccion_representante'] ?? '');
        $data['provincia_representante'] = trim($participant['provincia_representante'] ?? '');
        $data['CP_representante'] = trim($participant['codigo_postal_representante'] ?? '');
        $data['poblacion_representante'] = trim($participant['localidad_representante'] ?? '');
        $data['telefono_representante'] = preg_replace('/\s+/', '', $participant['telefono_fijo_representante'] ?? '');
        $data['movil_representante'] = preg_replace('/\s+/', '', $participant['telefono_representante'] ?? '');
        $data['email_representante'] = strtolower(trim($participant['email_representante'] ?? ''));
        // --- SEXO REPRESENTANTE ---
        $sexoRep = strtoupper(trim($participant['sexo_representante'] ?? ''));
        foreach (config('options.sexo') as $s) {
            $data['sexo_' . strtolower($s) . '_representante'] =
                $this->helper->handleRadioOption($sexoRep === strtoupper($s) ? 'On' : null);
        }

        // otros
        $data['horario_llamadas'] = trim($participant['horario_llamadas'] ?? '');

        // --- SEXO REPRESENTANTE ---
        $sexoRep = strtoupper(trim($participant['sexo_rep'] ?? ''));
        foreach (config('options.sexo') as $s) {
            $data['sexo_' . strtolower($s) . '_representante'] = $this->helper->handleRadioOption($sexoRep === $s ? 'On' : null);
        }

        // --- SITUACIÓN LABORAL ---
        $situacion = $participant['situacion_laboral'] ?? null;
        $data['trabajador_desempleado'] = $this->helper->handleRadioOption($situacion === 'desempleado' ? 'On' : null);
        $data['trabajador_ocupado'] = $this->helper->handleRadioOption($situacion === 'ocupado' ? 'On' : null);

        // --- Desempleado ---
        if ($situacion === 'desempleado') {
            $data['oficina_empleo'] = trim($participant['oficina_empleo'] ?? '');
            $data['fecha_inscripcion'] = $this->helper->formatDate($participant['fecha_inscripcion'] ?? null);

            $selected = $participant['situacion_desempleado'] ?? null;
            foreach (array_keys(config('options.situacion_desempleado')) as $key) {
                $data[$key] = $this->helper->handleRadioOption($selected === $key ? 'On' : null);
            }
        }

        // --- Ocupado ---
        if ($situacion === 'ocupado') {
            $data['sector'] = trim($participant['sector'] ?? '');
            $data['cif'] = trim($participant['cif'] ?? '');
            $data['razon_social'] = trim($participant['razon_social'] ?? '');
            $data['domicilio_trabajo'] = trim($participant['domicilio_trabajo'] ?? '');
            $data['localidad_trabajo'] = trim($participant['localidad_trabajo'] ?? '');
            $data['cp_trabajo'] = trim($participant['cp_trabajo'] ?? '');
            $data['regimen_cotizacion'] = trim($participant['regimen_cotizacion'] ?? '');

            $data['mas_250_trabajadores_si'] = $this->helper->handleRadioOption(
                ($participant['empresa_mas_250'] ?? null) === 'On' ? 'On' : null
            );
            $data['mas_250_trabajadores_no'] = $this->helper->handleRadioOption(
                ($participant['empresa_mas_250'] ?? null) === '' ? 'On' : null
            );

            foreach (array_keys(config('options.categorias')) as $key) {
                $data[$key] = $this->helper->handleRadioOption(!empty($participant[$key]) ? 'On' : null);
            }

            $data['categoria'] = $participant['categoria'] ?? '';
        }

        // --- NIVEL ACADÉMICO ---
        $nivelSeleccionado = $participant['nivel_academico'] ?? null;
        $nivelSeleccionadoNorm = $nivelSeleccionado ? mb_strtolower(trim($nivelSeleccionado)) : null;

        foreach (config('options.nivel_academico') as $nivelValor) {
            $nivelValorNorm = mb_strtolower(trim($nivelValor));
            $data[$nivelValor] = $this->helper->handleRadioOption(
                $nivelSeleccionadoNorm === $nivelValorNorm ? 'sí' : null,
                'On'
            );
        }
        $data['especialidad'] = $this->helper->capitalize(trim($participant['especialidad'] ?? ''));


        // --- IDIOMAS ---
        $idiomas = config('options.idiomas');
        $nivelesOficiales = config('options.niveles_oficiales');
        $nivelesNoOficiales = config('options.niveles_no_oficiales');
        $idiomasRecibidos = $participant['idiomas'] ?? []; // Datos recibidos en request, ej: ["INGLÉS"=>"INGLÉS=1", "B1"=>"1", ...]

        foreach ($idiomas as $index => $idioma) {
            $sufijo = $index === 0 ? '' : ($index === 1 ? '_2' : '_3'); // Inglés='', Francés='_2', Otro='_3'

            // Marcar idioma principal
            $data[$idioma] = isset($idiomasRecibidos[$idioma]) ? 'On' : null;

            // Niveles oficiales
            foreach ($nivelesOficiales as $nivel) {
                $key = $nivel . $sufijo;
                $data[$key] = (!empty($idiomasRecibidos[$idioma]['oficial']) && $idiomasRecibidos[$idioma]['oficial'] === $nivel) ? 'On' : null;
            }

            // Niveles no oficiales
            foreach ($nivelesNoOficiales as $nivel) {
                $key = $nivel . $sufijo;
                $data[$key] = (!empty($idiomasRecibidos[$idioma]['no_oficial']) && $idiomasRecibidos[$idioma]['no_oficial'] === $nivel) ? 'On' : null;
            }

            // Campo OTRO idioma real
            if ($idioma === 'OTRO') {
                $data['otro_idioma'] = $this->helper->capitalize(trim($idiomasRecibidos['OTRO']['valor'] ?? ''));
            }
        }

        // --- FORMACIÓN PROFESIONAL ---
        $data['curso'] = isset($participant['curso']) ?
            implode(', ', array_map([$this->helper, 'capitalize'], array_filter($participant['curso']))) : '';
        $data['anio_formacion'] = isset($participant['anio']) ? implode(', ', array_filter($participant['anio'])) : '';
        $data['duracion'] = isset($participant['duracion']) ? implode(', ', array_filter($participant['duracion'])) : '';
        $data['centro'] = isset($participant['centro']) ?
            implode(', ', array_map([$this->helper, 'capitalize'], array_filter($participant['centro']))) : '';
        $data['otro_curso'] = $this->helper->capitalize(trim($participant['otro_curso'] ?? ''));

        // --- EXPERIENCIA PROFESIONAL ---
        $data['puesto'] = $this->helper->capitalize(trim($participant['puesto'] ?? ''));
        $data['funciones'] = trim($participant['funciones'] ?? '');
        $data['empresa'] = $this->helper->capitalize(trim($participant['empresa'] ?? ''));
        $data['duracion_trabajo'] = trim($participant['duracion_trabajo'] ?? '');
        $data['sector_trabajo'] = $this->helper->capitalize(trim($participant['sector_anterior'] ?? ''));

        // --- MOTIVOS DE PARTICIPACIÓN ---
        $motivosSeleccionados = array_map(
            fn($m) => mb_strtolower(trim($m)),
            $participant['motivos'] ?? []
        );

        foreach (config('options.motivo_participacion') as $motivo => $motivoLabel) {
            $motivoNorm = mb_strtolower(trim($motivo));
            $data[$motivo] = $this->helper->handleRadioOption(
                in_array($motivoNorm, $motivosSeleccionados) ? 'sí' : null,
                'On'
            );
        }

        // --- AUTORIZACIONES ---
        $autorizacionesSeleccionadas = $participant['autorizaciones'] ?? [];
        foreach (config('options.autorizaciones') as $key => $label) {
            // Los nombres de campo en el PDF son la key de options.autorizaciones
            $data[$key] = $this->helper->handleRadioOption(
                in_array($key, $autorizacionesSeleccionadas, true) ? 'sí' : null,
                'On'
            );
        }

        // --- LUGAR Y FECHA ---
        $data['lugar'] = $this->helper->capitalize(trim($participant['lugar'] ?? ''));
        $data['fecha'] = $this->helper->formatDate($participant['fecha'] ?? null);

        // Log::info('[MecFormDataFormatterService] - FORMATTED data', ['data' => $data]);

        return $data;
    }
}
