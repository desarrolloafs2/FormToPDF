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
            'birthdate' => ['required', 'date', 'before:' . now()->subYears(16)->toDateString()],
            'direccion' => ['required', 'string', 'max:255'],
            'localidad' => ['required', 'string', 'max:100'],
            'codigo_postal' => ['required', 'regex:/^(0[1-9]|[1-4][0-9]|5[0-2])\d{3}$/'],
            'provincia' => ['required', 'in:' . implode(',', config('options.provincias'))],
            'telefono' => ['required', 'regex:/^(?:\+34|34)?\s?(6|7|8|9)\d{2}[\s-]?\d{3}[\s-]?\d{3}$/'],
            'telefono_fijo' => ['nullable', 'regex:/^[89]\d{8}$/'],
            'email' => ['required', 'email', 'max:255'],
            'carnet' => ['required', ''],
            'carnet_tipos' => ['nullable', 'string', 'max:255'],
            'nuss' => ['nullable', 'regex:/^\d{12}$/'], // Número de la Seguridad Social

            // --- Datos Representante ---
            'name_representante' => ['nullable', 'string', 'max:255', 'required_with:firstSurname_representante,nif_representante'],
            'firstSurname_representante' => ['nullable', 'string', 'max:255', 'required_with:name_representante,nif_representante'],
            'apellido2_representante' => ['nullable', 'string', 'max:255'],
            'nif_representante' => ['nullable', 'string', 'max:50', 'required_with:firstSurname_representante,name_representante'],
            'sexo_representante' => ['nullable', 'in:' . implode(',', config('options.sexo'))],
            'direccion_representante' => ['nullable', 'string', 'max:255', 'required_with:poblacion_representante,CP_representante,provincia_representante'],
            'localidad_representante' => ['nullable', 'string', 'max:255', 'required_with:direccion_representante,CP_representante,provincia_representante'],
            'codigo_postal_representante' => ['nullable', 'string', 'max:10', 'required_with:direccion_representante,poblacion_representante,provincia_representante'],
            'provincia_representante' => ['nullable', 'in:' . implode(',', config('options.provincias')), 'required_with:direccion_representante,poblacion_representante,CP_representante'],
            'email_representante' => ['nullable', 'email', 'max:255'],
            'telefono_movil_representante' => ['nullable', 'regex:/^(?:\+34|34)?\s?(6|7|8|9)\d{2}[\s-]?\d{3}[\s-]?\d{3}$/'],
            'telefono_fijo_representante' => ['nullable', 'regex:/^[89]\d{8}$/'],

            // --- Horario de llamadas (común a ambos) ---
            'horario_llamadas' => ['nullable', 'string', 'max:100'],

            // Situación Laboral
            'situacion_laboral' => ['required', 'in:' . implode(',', array_keys(config('options.situacion_laboral')))],

            // Caso desempleado
            'oficina_empleo' => ['required_if:situacion_laboral,desempleado', 'string', 'max:255'],
            'fecha_inscripcion' => ['required_if:situacion_laboral,desempleado', 'date'],
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
            'empresa_mas_250' => 'required_if:situacion_laboral,ocupado',

            // Categorías (checkboxes dinámicos)
            ...collect(array_keys(config('options.categorias')))
                ->mapWithKeys(fn($key) => [$key => ['nullable', '']])
                ->toArray(),

            'categoria' => ['required_if:situacion_laboral,ocupado', 'in:' . implode(',', array_keys(config('options.categorias')))],

            // Datos Académicos
            'nivel_academico' => ['required', 'in:' . implode(',', array_keys(config('options.nivel_academico')))],
            'especialidad' => ['nullable', 'string', 'max:255'],

            // Formación Profesional
            'curso' => ['nullable', 'array'],
            'curso.*' => ['nullable', 'string', 'max:255'],
            'anio' => ['nullable', 'array'],
            'anio.*' => ['nullable', 'digits:4', 'integer'],
            'duracion' => ['nullable', 'array'],
            'duracion.*' => ['nullable', 'integer', 'min:1'],
            'centro' => ['nullable', 'array'],
            'centro.*' => ['nullable', 'string', 'max:255'],
            'otro_curso' => ['nullable', 'string', 'max:255'],

            // Experiencia Profesional
            'puesto' => ['nullable', 'string', 'max:255'],
            'funciones' => ['nullable', 'string', 'max:500'],
            'empresa' => ['nullable', 'string', 'max:255'],
            'duracion_trabajo' => ['nullable', 'numeric', 'min:0'],
            'sector_anterior' => ['nullable', 'string', 'max:255'],

            // --- Idiomas ---
            'idiomas' => ['nullable', 'array'],
            'idiomas.*.activo' => ['nullable', 'in:1'],
            'idiomas.*.oficial' => ['nullable', 'in:' . implode(',', array_merge(config('options.niveles_oficiales'), config('options.niveles_no_oficiales')))],
            'idiomas.*.no_oficial' => ['nullable', 'in:' . implode(',', config('options.niveles_no_oficiales'))],
            'idiomas.OTRO.valor' => ['nullable', 'string', 'max:255'],

            // Motivos
            'motivo_interes' => 'nullable',
            'motivo_prestacion' => 'nullable',
            'motivo_cualificacion' => 'nullable',
            'motivo_trabajo' => 'nullable',
            'motivo_sector' => 'nullable',
            'motivo_otros' => 'nullable',

            /// Motivos (array de checkboxes, no obligatorio)
            'motivos' => ['array'],
            'motivos.*' => ['in:' . implode(',', array_keys(config('options.motivo_participacion')))],

            // Autorizaciones (array de checkboxes, no obligatorio)
            'autorizaciones' => ['array'],
            'autorizaciones.*' => ['in:' . implode(',', array_keys(config('options.autorizaciones')))],
            // Firma y lugar
            'lugar' => ['required', 'string', 'max:100'],
            'fecha' => ['required', 'date'],
            'signature' => ['required'],
        ];


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
        // -------------------- VALIDACIÓN DE MOTIVOS --------------------
        $validator->after(function ($validator) {
            $motivos = $this->input('motivos', []);
            if (!is_array($motivos) || count($motivos) === 0) {
                $validator->errors()->add('motivos', 'Debe seleccionar al menos un motivo.');
            }
        });

        // -------------------- VALIDACIÓN DE IDIOMAS --------------------
        // $idiomas = config('options.idiomas');

        // Validación de idiomas
        $validator->after(function ($validator) {
            $idiomas = $this->input('idiomas', []);
            foreach ($idiomas as $idioma => $info) {
                if (!empty($info['activo']) && empty($info['oficial']) && empty($info['no_oficial']) && strtoupper($idioma) !== 'OTRO') {
                    $validator->errors()->add("idiomas.$idioma.oficial", "Debe seleccionar un nivel para el idioma $idioma.");
                }
                if ($idioma === 'OTRO' && !empty($info['activo']) && empty($info['valor'])) {
                    $validator->errors()->add("idiomas.OTRO.valor", 'Debe especificar el idioma si selecciona "Otro".');
                }
            }
        });

        // -------------------- VALIDACIÓN DE CATEGORÍAS --------------------
        $validator->after(function ($validator) {
            if ($this->input('situacion_laboral') === 'ocupado') {
                $categorias = array_keys(config('options.categorias'));
                $anyChecked = collect($categorias)->some(fn($cat) => !empty($this->input($cat)));
                if (!$anyChecked) {
                    $validator->errors()->add('categorias', 'Debe seleccionar al menos una categoría.');
                }
            }
        });
    }

    public function attributes(): array
    {
        return [
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
            'nuss' => 'número de la seguridad social',
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
            'nivel_academico' => 'nivel académico',
            'especialidad' => 'especialidad',
            'curso' => 'curso',
            'anio' => 'año',
            'duracion' => 'duración',
            'centro' => 'centro',
            'otro_curso' => 'otro curso',
            'puesto' => 'puesto',
            'funciones' => 'funciones',
            'empresa' => 'empresa',
            'duracion_trabajo' => 'duración del trabajo',
            'sector_anterior' => 'sector anterior',
            'motivo_interes' => 'motivo de interés',
            'motivo_prestacion' => 'motivo de prestación',
            'motivo_cualificacion' => 'motivo de cualificación',
            'motivo_trabajo' => 'motivo de trabajo',
            'motivo_sector' => 'motivo de sector',
            'motivo_otros' => 'otros motivos',
            'lugar' => 'lugar',
            'fecha' => 'fecha',
            'signature' => 'firma',
        ];
    }

    public function messages(): array
    {
        return [
            'autorizaciones.*.in' => 'El valor seleccionado para :attribute no es válido.',
            'motivos.*.in' => 'El valor seleccionado para :attribute no es válido.',
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
            'signature.required' => 'La firma es obligatoria.',
            'codigo_postal.regex' => 'El formato del código postal es incorrecto.',
            'telefono.regex' => 'El formato del teléfono móvil es inválido.',
            'motivos.required' => 'Debe seleccionar al menos un motivo.',
            'categorias.required' => 'Debe seleccionar al menos una categoría si está ocupado.',
            'NIVEL_OTRO.required' => 'Debe seleccionar un nivel para "Otro idioma".',
        ];
    }
}
