<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EoiParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Datos personales
            'apellido1' => ['required', 'string', 'max:100'],
            'apellido2' => ['nullable', 'string', 'max:100'],
            'nombre' => ['required', 'string', 'max:100'],
            'tipo_documento' => ['required', 'in:DNI,NIE,PASAPORTE'],
            'documento' => ['required', 'string', 'max:20'],
            'sexo' => ['nullable', 'in:Hombre,Mujer,Otro'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'codigo_postal' => ['nullable', 'string', 'max:10'],
            'provincia' => ['nullable', 'string', 'max:100'],
            'ccaa' => ['nullable', 'string', 'max:100'],
            'telefono' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:150'],

            // Datos profesionales
            'empresa' => ['required', 'string', 'max:255'],
            'nif_empresa' => ['required', 'string', 'max:20'],

            // Nuevos campos adicionales
            'reside_en_localidad_menor_5000' => ['required', 'in:Sí,No'],
            'discapacidad' => ['nullable', 'in:Sí,No'],
            'nivel_estudios' => ['required', 'in:CINE 5 a 8,CINE 3 a 4,CINE 1 a 2'],
            'titulacion' => ['nullable', 'string', 'max:150'],
            'situacion_actual' => ['required', 'in:Directivo en una pyme,Trabajador en una pyme'],

            // Declaraciones
            'trabaja_en_pyme' => ['accepted'],
            'info_veraz' => ['accepted'],
            'no_duplicado' => ['accepted'],
            'sin_conflicto' => ['accepted'],
            'autorizo_datos' => ['accepted'],

            'condiciones' => ['accepted'],
            'autorizo_discapacidad' => ['nullable'], // no obligatoria

            // Firma y lugar
            'lugar' => ['nullable', 'string', 'max:100'],
            'fecha' => ['nullable', 'date'],
            'firma' => ['nullable', 'string', 'max:150'],

            'dni_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'contrato_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'declaracion_responsable' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],

        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'El campo :attribute debe ser un correo electrónico válido.',
            'accepted' => 'Debe aceptar el campo :attribute.',
            'in' => 'El valor seleccionado para :attribute no es válido.',
        ];
    }

    public function attributes(): array
    {
        return [
            'apellido1' => 'primer apellido',
            'apellido2' => 'segundo apellido',
            'nombre' => 'nombre',
            'tipo_documento' => 'tipo de documento',
            'documento' => 'número de documento',
            'sexo' => 'sexo',
            'fecha_nacimiento' => 'fecha de nacimiento',
            'direccion' => 'dirección',
            'ciudad' => 'ciudad',
            'codigo_postal' => 'código postal',
            'provincia' => 'provincia',
            'ccaa' => 'comunidad autónoma',
            'telefono' => 'teléfono',
            'email' => 'correo electrónico',
            'empresa' => 'nombre de la empresa',
            'nif_empresa' => 'NIF de la empresa',
            'reside_en_localidad_menor_5000' => 'residencia en localidad < 5000 habitantes',
            'discapacidad' => 'discapacidad',
            'nivel_estudios' => 'nivel de estudios finalizados',
            'titulacion' => 'titulación',
            'situacion_actual' => 'situación actual',
            'trabaja_en_pyme' => 'declaración de empleo en pyme',
            'info_veraz' => 'veracidad de la información',
            'no_duplicado' => 'no duplicidad de curso',
            'sin_conflicto' => 'conflicto de interés',
            'autorizo_datos' => 'autorización de datos',
            'lugar' => 'lugar',
            'fecha' => 'fecha',
            'firma' => 'firma del participante',
            'dni_file' => 'copia del documento de identidad',
            'contrato_file' => 'documento laboral',
            'declaracion_responsable' => 'declaración responsable',

        ];
    }
}
