<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Rules\DniNieRule;
use App\Rules\CifOrDniNieRule;
use App\Traits\LongTextRules;

class EoiParticipantRequest extends FormRequest
{
    use LongTextRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Datos personales
            'firstSurname' => $this->textRule(3, 100),
            'apellido2' => $this->textRule(3, 100),
            'name' => $this->textRule(3, 100),
            'tipo_documento' => ['required', 'in:NIF,NIE,PASS'],
            'nif' => ['required', new DniNieRule()],
            'sexo' => ['required', 'in:M,F,NB'],
            'fecha_nacimiento' => ['required', 'date',  'before_or_equal:today'],
            'direccion' => $this->textRule(3, 255),
            'ciudad' => $this->textRule(3, 100),
            'codigo_postal' => ['required', 'regex:/^(0[1-9]|[1-4][0-9]|5[0-2])\d{3}$/'],
            'provincia' => $this->textRule(3, 100),
            'ccaa' => $this->textRule(3, 100),
            'telefono' => ['required', 'regex:/^(?:\+34|34)?\s?(6|7|8|9)\d{2}[\s-]?\d{3}[\s-]?\d{3}$/'],
            'email' => ['required', 'email', 'max:150'],

            // Datos profesionales
            'empresa' => $this->textRule(3, 255),
            'nif_empresa' => ['required', new CifOrDniNieRule()],
            'actividad_empresa' => ['required', 'string', 'min:5', 'max:255'],
            'tamano_empresa' => ['required'],
            'province' => ['required'],
            'ccaa_empresa' => ['required'],
            'antiguedad_empresa' => ['required'],
            'facturacion' => ['required'],
            'ambito_rural' => ['required'],
            'politicas_sostenibilidad' => ['required'],
            'transformacion_digital' => ['required'],
            'mujer_responsable' => ['required'],
            'porcentaje_mujeres' => ['required'],

            // Campos adicionales
            'reside_en_localidad_menor_5000' => ['required'],
            'discapacidad' => ['nullable'],
            'nivel_estudios' => ['required'],
            'titulacion' => $this->textRule(5, 150),
            'situacion_actual' => ['required'],
            'relacion_empresa' => ['required'],

            // Declaraciones (checkbox)
            'trabaja_en_pyme' => ['accepted'],
            'info_veraz' => ['accepted'],
            'no_duplicado' => ['accepted'],
            'sin_conflicto' => ['accepted'],
            'autorizo_datos' => ['accepted'],
            'condiciones' => ['accepted'],
            'autorizo_discapacidad' => ['nullable'],

            // Firma y lugar
            'lugar' => $this->textRule(3, 100),
            'fecha' => ['required', 'date', 'before_or_equal:today'],

            // Archivos
            'dni_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'contrato_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'declaracion_responsable' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],

            // Firma digital o imagen
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
            'codigo_postal.regex' => 'El formato del código postal es incorrecto.',
            'telefono.regex' => 'El formato del teléfono es inválido.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
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
            'relacion_empresa' => 'relación con la empresa',
            'trabaja_en_pyme' => 'declaración de empleo en pyme',
            'info_veraz' => 'veracidad de la información',
            'no_duplicado' => 'no duplicidad de curso',
            'sin_conflicto' => 'conflicto de interés',
            'autorizo_datos' => 'autorización de datos',
            'lugar' => 'lugar',
            'fecha' => 'fecha',
            'signature' => 'firma del participante',
            'dni_file' => 'copia del documento de identidad',
            'contrato_file' => 'documento laboral',
            'declaracion_responsable' => 'declaración responsable',
        ];
    }
}
