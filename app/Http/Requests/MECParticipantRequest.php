<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DniNieRule;
use App\Rules\CifOrDniNieRule;

class MecParticipantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            // Datos Personales
            'firstSurname' => ['required', 'string', 'max:255'],
            'apellido2' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'sexo' => ['required', 'in:' . implode(',', config('options.sexo'))],
            'tipo_via' => ['required', 'in:' . implode(',', config('options.via'))],
            'nif' => ['required', new DniNieRule()],
            'direccion' => ['required', 'string', 'max:255'],
            'localidad' => ['required', 'string', 'max:100'],
            'codigo_postal' => ['required', 'regex:/^(0[1-9]|[1-4][0-9]|5[0-2])\d{3}$/'],
            'provincia' => ['required', 'in:' . implode(',', config('options.provincias'))],
            'telefono' => ['required', 'regex:/^(?:\+34|34)?\s?(6|7|8|9)\d{2}[\s-]?\d{3}[\s-]?\d{3}$/'],
            'telefono_fijo' => ['nullable', 'regex:/^[89]\d{8}$/'],
            'email' => ['required', 'email', 'max:255'],
            'carnet' => ['required', 'in:si,no'],
            'carnet_tipos' => ['nullable', 'string', 'max:255'],

            // Datos Representante
            'firstSurname_rep' => ['nullable', 'string', 'max:255'],
            'apellido2_rep' => ['nullable', 'string', 'max:255'],
            'name_rep' => ['nullable', 'string', 'max:255'],
            'tipo_documento_rep' => ['nullable', 'in:' . implode(',', config('options.dni'))],
            'nif_rep' => ['nullable', 'string', 'max:50'],
            'sexo_rep' => ['nullable', 'in:' . implode(',', config('options.sexo'))],
            'direccion_rep' => ['nullable', 'string', 'max:255'],
            'poblacion_rep' => ['nullable', 'string', 'max:255'],
            'CP_rep' => ['nullable', 'string', 'max:10'],
            'provincia_rep' => ['nullable', 'in:' . implode(',', config('options.provincias'))],
            'email_rep' => ['nullable', 'email', 'max:255'],
            'telefono_movil_rep' => ['nullable', 'string', 'max:20'],
            'telefono_fijo_rep' => ['nullable', 'string', 'max:20'],
            'horario_llamadas' => ['nullable', 'string', 'max:100'],

            // Situación Laboral
            'situacion_laboral' => ['required', 'in:' . implode(',', array_keys(config('options.situacion_laboral')))],

            // Caso desempleado
            'oficina_empleo' => ['required_if:situacion_laboral,desempleado', 'string', 'max:255'],
            'fecha_inscripcion' => ['required_if:situacion_laboral,desempleado', 'date'],

            // Radio de situación desempleado
            'situacion_desempleado' => [
                'required_if:situacion_laboral,desempleado',
                'string',
                'in:' . implode(',', array_keys(config('options.situacion_desempleado')))
            ],

            // Caso ocupado
            'sector' => ['required_if:situacion_laboral,ocupado', 'string', 'max:255'],
            'cif' => ['nullable', 'string', 'max:20'],
            'razon_social' => ['nullable', 'string', 'max:255'],
            'domicilio_trabajo' => ['required_if:situacion_laboral,ocupado', 'string', 'max:255'],
            'localidad_trabajo' => ['required_if:situacion_laboral,ocupado', 'string', 'max:255'],
            'cp_trabajo' => ['nullable', 'digits_between:4,5'],
            'regimen_cotizacion' => ['nullable', 'string', 'max:50'],

            // Categorías (primer bloque: checkboxes, segundo bloque: radio requerido)
            ...collect(array_keys(config('options.categorias')))
                ->mapWithKeys(fn($key) => [$key => ['nullable', 'boolean']])
                ->toArray(),

            'categoria' => ['required_if:situacion_laboral,ocupado', 'in:' . implode(',', array_keys(config('options.categorias')))],


            // Datos Académicos
            'nivel_academico' => ['required', 'in:' . implode(',', array_keys(config('options.nivel_academico')))],
            'especialidad' => ['nullable', 'string', 'max:255'],
            
            //Formación Profesional
            'curso' => ['nullable', 'array'],
            'curso.*' => ['nullable', 'string', 'max:255'],
            'anio' => ['nullable', 'array'],
            'anio.*' => ['nullable', 'digits:4', 'integer'],
            'duracion' => ['nullable', 'array'],
            'duracion.*' => ['nullable', 'integer', 'min:1'],
            'centro' => ['nullable', 'array'],
            'centro.*' => ['nullable', 'string', 'max:255'],
            'otro_curso' => ['required', 'in:si,no'],
            'otro_curso_text' => ['string', 'max:255', 'required_if:otro_curso,si'],

            // Experiencia Profesional
            'puesto' => ['nullable', 'string', 'max:255'],
            'funciones' => ['nullable', 'string', 'max:500'],
            'empresa' => ['nullable', 'string', 'max:255'],
            'duracion_trabajo' => ['nullable', 'numeric', 'min:0'],
            'sector_anterior' => ['nullable', 'string', 'max:255'],

            // Motivos
            'motivo_interes' => 'nullable',
            'motivo_prestacion' => 'nullable',
            'motivo_cualificacion' => 'nullable',
            'motivo_trabajo' => 'nullable',
            'motivo_sector' => 'nullable',
            'motivo_otros' => 'nullable',

            // Firma y lugar
            'lugar' => ['nullable', 'string', 'max:100'],
            'fecha' => ['nullable', 'date'],
            'signature' => ['required']

        ];

        // idiomas
        $idiomas = config('options.idiomas');
        $nivelesOficiales = config('options.niveles_oficiales');
        $nivelesNoOficiales = config('options.niveles_no_oficiales');
        foreach ($idiomas as $index => $idioma) {
            $index1 = $index + 1;
            // Checkbox general del idioma
            $rules['IDIOMA_' . $index1] = ['nullable', 'boolean'];
            // Radios niveles oficiales
            $rules['OFICIAL_' . $index1] = ['nullable', 'in:' . implode(',', $nivelesOficiales)];
            // Radios niveles no oficiales
            $rules['NO_OFICIAL_' . $index1] = ['nullable', 'in:' . implode(',', $nivelesNoOficiales)];
        }
        // Campo para especificar otro idioma
        $rules['OTRO'] = ['nullable', 'string', 'max:255'];

        return $rules;
    }

    protected function validateAtLeastOneChecked($validator, array $fields, string $errorField, string $message)
    {
        $validator->after(function ($validator) use ($fields, $errorField, $message) {
            $anyChecked = false;
            foreach ($fields as $field) {
                if ($this->input($field)) {
                    $anyChecked = true;
                    break;
                }
            }
            if (!$anyChecked) {
                $validator->errors()->add($errorField, $message);
            }
        });
    }

    public function withValidator($validator)
    {
        // Validación de motivos (ya existente)
        $this->validateAtLeastOneChecked($validator, [
            'motivo_interes',
            'motivo_prestacion',
            'motivo_cualificacion',
            'motivo_trabajo',
            'motivo_sector',
            'motivo_otros',
        ], 'motivos', 'Debe seleccionar al menos un motivo.');

        $idiomas = config('options.idiomas');
        $idiomaFields = [];
        foreach ($idiomas as $index => $idioma) {
            $idiomaFields[] = 'IDIOMA_' . ($index + 1);
        }

        $validator->after(function ($validator) use ($idiomas) {
            $otroIndex = count($idiomas) - 1; // Último idioma es "Otro idioma"
            $otroCheckbox = 'IDIOMA_' . ($otroIndex + 1);
            $oficial = 'OFICIAL_' . ($otroIndex + 1);
            $noOficial = 'NO_OFICIAL_' . ($otroIndex + 1);
            if ($this->input($otroCheckbox)) {
                // El campo OTRO es obligatorio si se marca el checkbox
                if (!$this->filled('OTRO')) {
                    $validator->errors()->add('OTRO', 'Debe especificar el idioma si selecciona "Otro idioma".');
                }
                // Debe marcarse al menos un nivel
                if (!$this->filled($oficial) && !$this->filled($noOficial)) {
                    $validator->errors()->add('NIVEL_OTRO', 'Debe seleccionar un nivel para "Otro idioma".');
                }
            }
        });
    }


    public function attributes(): array
    {
        return [
            // Datos Personales
            'firstSurname' => 'primer apellido',
            'apellido2' => 'segundo apellido',
            'name' => 'nombre',
            'sexo' => 'sexo',
            'tipo_documento' => 'tipo de documento',
            'nif' => 'número de documento',
            'fecha_nacimiento' => 'fecha de nacimiento',
            'direccion' => 'dirección',
            'ciudad' => 'ciudad',
            'codigo_postal' => 'código postal',
            'provincia' => 'provincia',
            'telefono' => 'teléfono móvil',
            'telefono_fijo' => 'teléfono fijo',
            'email' => 'correo electrónico',
            'carnet' => 'carnet de conducir',
            'carnet_tipos' => 'tipo de carnet',

            // Datos Representante
            'firstSurname_rep' => 'primer apellido del representante',
            'apellido2_rep' => 'segundo apellido del representante',
            'name_rep' => 'nombre del representante',
            'tipo_documento_rep' => 'tipo de documento del representante',
            'nif_rep' => 'número de documento del representante',
            'sexo_rep' => 'sexo del representante',
            'direccion_rep' => 'dirección del representante',
            'poblacion_rep' => 'población del representante',
            'CP_rep' => 'código postal del representante',
            'provincia_rep' => 'provincia del representante',
            'email_rep' => 'correo electrónico del representante',
            'telefono_movil_rep' => 'teléfono móvil del representante',
            'telefono_fijo_rep' => 'teléfono fijo del representante',
            'horario_llamadas' => 'horario para llamadas',

            // Situación Laboral
            'situacion_laboral' => 'situación laboral',
            'oficina_empleo' => 'oficina de empleo',
            'fecha_inscripcion' => 'fecha de inscripción',
            'sector' => 'sector laboral',
            'cif' => 'CIF de la empresa',
            'razon_social' => 'razón social',
            'domicilio_trabajo' => 'domicilio del trabajo',
            'localidad_trabajo' => 'localidad del trabajo',
            'cp_trabajo' => 'código postal del trabajo',
            'regimen_cotizacion' => 'régimen de cotización',

            // Datos Académicos
            'sin_estudios' => 'sin estudios',
            'estudios_primarios' => 'estudios primarios',
            'certificado_escolaridad' => 'certificado de escolaridad',
            'graduado_escolar' => 'graduado escolar',
            'eso' => 'ESO',
            'fp1' => 'FP1',
            'ciclo_grado_medio' => 'ciclo de grado medio',
            'bup_1_2' => 'BUP 1º y 2º',
            'bup_1_2_3' => 'BUP 1º, 2º y 3º',
            'fp2' => 'FP2',
            'ciclo_grado_superior' => 'ciclo de grado superior',
            'cou' => 'COU',
            'bachiller' => 'bachillerato',
            'diplomatura' => 'diplomatura',
            'licenciatura' => 'licenciatura',
            'grado' => 'grado universitario',
            'doctorado' => 'doctorado',
            'certificado_profesional_n1' => 'certificado profesional nivel 1',
            'certificado_profesional_n2' => 'certificado profesional nivel 2',
            'certificado_profesional_n3' => 'certificado profesional nivel 3',
            'otros' => 'otros estudios',
            'especialidad' => 'especialidad',

            // Formación Profesional (arrays)
            'curso' => 'curso',
            'anio' => 'año',
            'duracion' => 'duración',
            'centro' => 'centro',
            'otro_curso' => 'otro curso',
            'otro_curso_text' => 'detalle de otro curso',

            // Experiencia Profesional
            'puesto' => 'puesto',
            'funciones' => 'funciones',
            'empresa' => 'empresa',
            'duracion_trabajo' => 'duración del trabajo',
            'sector_anterior' => 'sector anterior',

            // Motivos (checkboxes)
            'motivo_interes' => 'motivo de interés',
            'motivo_prestacion' => 'motivo de prestación',
            'motivo_cualificacion' => 'motivo de cualificación',
            'motivo_trabajo' => 'motivo de trabajo',
            'motivo_sector' => 'motivo de sector',
            'motivo_otros' => 'otros motivos',

            // Firma y lugar
            'lugar' => 'lugar',
            'fecha' => 'fecha',
            'signature' => 'firma',

            // Campos generados dinámicamente (ejemplo idiomas)
            // Puedes añadir a mano si quieres para idiomas, niveles, etc.

        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'required_if' => 'El campo :attribute es obligatorio cuando :other es :value.',
            'boolean' => 'El campo :attribute debe ser verdadero o falso.',
            'string' => 'El campo :attribute debe ser una cadena de texto.',
            'max' => 'El campo :attribute no puede tener más de :max caracteres.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
            'email' => 'El campo :attribute debe ser un correo electrónico válido.',
            'in' => 'El valor seleccionado para :attribute no es válido.',
            'regex' => 'El formato del campo :attribute es incorrecto.',
            'digits' => 'El campo :attribute debe tener exactamente :digits dígitos.',
            'array' => 'El campo :attribute debe ser un arreglo.',
            'accepted' => 'Debe aceptar el campo :attribute.',
            'after' => 'La fecha :attribute debe ser posterior a :date.',

            // Mensajes personalizados específicos
            'signature.required' => 'La firma es obligatoria.',
            'codigo_postal.regex' => 'El formato del código postal es incorrecto.',
            'telefono.regex' => 'El formato del teléfono móvil es inválido.',
            'motivos.required' => 'Debe seleccionar al menos un motivo.',

            // Puedes añadir mensajes para campos dinámicos si lo deseas
            // Ejemplo para idiomas o niveles:
            // 'BÁSICO_1.boolean' => 'El valor para Básico 1 debe ser verdadero o falso.',
        ];
    }


}
