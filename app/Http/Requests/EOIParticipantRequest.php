<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DniNieRule;
use App\Rules\CifOrDniNieRule;

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
            'firstSurname' => ['required', 'string', 'max:100'],
            'apellido2' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:100'],
            'tipo_documento' => ['required', 'in:DNI,NIE,PASAPORTE'],
            'nif' => ['required', new DniNieRule()],
            'sexo' => ['required', 'in:Hombre,Mujer,Otro'],
            'fecha_nacimiento' => ['required', 'date', 'before:today'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'ciudad' => ['required', 'string', 'max:100'],
            'codigo_postal' => ['nullable', 'regex:/^(0[1-9]|[1-4][0-9]|5[0-2])\d{3}$/'],
            'provincia' => ['required', 'string', 'max:100'],
            'ccaa' => ['nullable', 'string', 'max:100'],
            'telefono' => ['required', 'regex:/^(?:\+34|34)?\s?(6|7|8|9)\d{2}[\s-]?\d{3}[\s-]?\d{3}$/'],
            'email' => ['required', 'email', 'max:150'],

            // Datos profesionales
            'empresa' => ['required', 'string', 'max:255'],
            'nif_empresa' => ['required', new CifOrDniNieRule()],
            'actividad_empresa' => ['nullable', 'string', 'max:255'],
            'tamano_empresa' => ['nullable', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'], // o cambiarlo a 'provincia_empresa'
            'ccaa_empresa' => ['nullable', 'string', 'max:100'],
            'antiguedad_empresa' => ['nullable', 'string', 'max:50'],
            'facturacion' => ['nullable', 'string', 'max:100'],
            'ambito_rural' => ['nullable', 'in:1,2'],
            'politicas_sostenibilidad' => ['nullable', 'in:1,2'],
            'transformacion_digital' => ['nullable', 'in:1,2'],
            'mujer_responsable' => ['nullable', 'in:1,2'],
            'porcentaje_mujeres' => ['nullable'],


            // Nuevos campos adicionales
            'reside_en_localidad_menor_5000' => ['nullable',],
            'discapacidad' => ['nullable'],
            'nivel_estudios' => ['required'],
            'titulacion' => ['nullable', 'string', 'max:150'],
            'situacion_actual' => ['required'],

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
            // 'firma' => ['nullable', 'string', 'max:150'],

            'dni_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'contrato_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'declaracion_responsable' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'signature' => ['required']


        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'El campo :attribute debe ser un correo electrónico válido.',
            'accepted' => 'Debe aceptar el campo :attribute.',
            'in' => 'El valor seleccionado para :attribute no es válido.',
            'postalCode.regex' => 'El formato del código postal es incorrecto',
            'phone.regex' => 'El formato del teléfono es inválido',
            'birthdate.before' => 'La fecha de nacimiento debe ser anterior a hoy',
        ];
    }

    public function attributes(): array
    {
        return [
            'firstSurname' => 'primer apellido',
            'apellido2' => 'segundo apellido',
            'name' => 'nombre',
            'tipo_documento' => 'tipo de documento',
            'nif' => 'número de documento',
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
