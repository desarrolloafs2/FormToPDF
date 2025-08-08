@extends('layouts.app')

@section('title', 'Formulario de Inscripción')

@section('content')
    <h1 class="mb-4 text-center">Formulario de Inscripción</h1>

    <form id="{{ $type }}" class="my-5" method="POST" action="{{ url($type) }}" enctype="multipart/form-data">
        @csrf

        <div class="container-fluid">
            <div class="row">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h2 class="text-center mb-5">Datos Personales</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <h5 class="alert-heading">¡Oops! Ha habido un error:</h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="container-fluid">
                        <!-- Apellidos -->
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-4">
                                <label for="apellido1" class="form-label">Primer Apellido *</label>
                                <input type="text" class="form-control" id="apellido1" name="apellido1" required>
                            </div>
                            <div class="col-lg-6 col-12 mb-4">
                                <label for="apellido2" class="form-label">Segundo Apellido</label>
                                <input type="text" class="form-control" id="apellido2" name="apellido2">
                            </div>
                        </div>

                        <!-- Nombre y tipo de documento -->
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-4">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-lg-6 col-12 mb-4">
                                <x-select id="tipo_documento" name="tipo_documento" label="Tipo de Documento"
                                    :options="array_combine(config('options.dni'), config('options.dni'))" required />
                            </div>
                        </div>

                        <!-- Documento y sexo -->
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-4">
                                <label for="documento" class="form-label">Nº de Documento *</label>
                                <input type="text" class="form-control" id="documento" name="documento" required>
                            </div>
                            <div class="col-lg-6 col-12 mb-4">
                                <x-select name="sexo" label="Género" :options="array_combine(config('options.sexo'), config('options.sexo'))" required />
                            </div>
                        </div>
                    </div>

                    <!-- Fecha y dirección -->
                    <div class="row">
                        <div class="col-lg-4 col-12 mb-4">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                        </div>
                        <div class="col-lg-8 col-12 mb-4">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion">
                        </div>
                    </div>

                    <!-- Ciudad, CP, provincia, CCAA -->
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad">
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="codigo_postal" class="form-label">Código Postal</label>
                            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal">
                        </div>

                        <div class="col-md-3 mb-4">
                            <x-select id="provincia" name="provincia" label="Provincia*" :options="array_combine(config('options.provincias'), config('options.provincias'))" />
                        </div>

                        <div class="col-md-3 mb-4">
                            <x-select name="ccaa" label="Comunidad Autónoma" :options="array_combine(config('options.ccaa'), config('options.ccaa'))" required />
                        </div>
                    </div>

                    <!-- Contacto -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="telefono" class="form-label">Teléfono Móvil *</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="email" class="form-label">Correo Electrónico *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>

                    <!-- Datos adicionales (residencia, discapacidad, estudios) -->
                    <h2 class="text-center mb-5">Información Adicional</h2>

                    <!-- ¿Reside en localidad menor de 5.000 hab? -->
                    <div class="mb-3">
                        <fieldset id="reside_en_localidad_menor_5000">
                            <label class="form-label d-block">¿Reside en una localidad con un número de habitantes inferior
                                a 5.000?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="reside_en_localidad_menor_5000"
                                    id="reside_si" value="1">
                                <label class="form-check-label" for="reside_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="reside_en_localidad_menor_5000"
                                    id="reside_no" value="2">
                                <label class="form-check-label" for="reside_no">No</label>
                            </div>
                        </fieldset>
                    </div>

                    <!-- ¿Tiene discapacidad? -->
                    <div class="mb-3">
                        <fieldset id="discapacidad">
                            <label class="form-label d-block text-danger">¿Persona con discapacidad? (No
                                obligatoria)</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="discapacidad" id="discapacidad_si"
                                    value="1">
                                <label class="form-check-label" for="discapacidad_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="discapacidad" id="discapacidad_no"
                                    value="2">
                                <label class="form-check-label" for="discapacidad_no">No</label>
                            </div>
                        </fieldset>
                    </div>

                    <!-- Nivel de estudios -->
                    <div class="mb-3">
                        <label for="nivel_estudios" class="form-label">Nivel de Estudios Finalizados</label>
                        <select class="form-select" id="nivel_estudios" name="nivel_estudios">
                            <option value="">Selecciona</option>
                            </option>
                            <option value="CINE 1: Enseñanza primaria">CINE 1: Educación Primaria</option>
                            <option
                                value="CINE 2: Primer Ciclo de Enseñanza Secundaria. (Incluye: 1º Ciclo de ESO y certificados profesionalidad 1 y 2 )">
                                CINE 2: Primer Ciclo de Enseñanza Secundaria. (Incluye: 1º Ciclo de
                                ESO y certificados profesionalidad 1 y 2 )</option>
                            <option
                                value="CINE 3: Segundo Ciclo de enseñanza secundaria.  (Incluye: FP Básica, FP Grado Medio, Bachillerato)">
                                CINE 3: Segundo Ciclo de enseñanza secundaria. (Incluye: FP Básica,
                                FP Grado Medio, Bachillerato)</option>
                            <option
                                value="CINE 4: Enseñanza Postsecundaria no Terciaria. Incluye certificado de profesionalidad 3 ">
                                CINE 4: Enseñanza Postsecundaria no Terciaria. Incluye certificado
                                de profesionalidad 3</option>
                            <option value="CINE 5 a 8: Enseñanza Superior, Universidad, FP Grado Superior ">CINE 5 a 8:
                                Enseñanza Superior, Universidad, FP Grado Superior
                            <option value="Otros">Otros</option>
                        </select>
                    </div>

                    <!-- Titulación -->
                    <div class="mb-3">
                        <label for="titulacion" class="form-label">Titulación</label>
                        <input type="text" class="form-control" id="titulacion" name="titulacion">
                    </div>

                    <!-- Situación Actual -->
                    <div class="mb-4">
                        <fieldset id="situacion_actual">
                            <label class="form-label d-block">Situación Actual</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="situacion_actual" id="directivo"
                                    value="1">
                                <label class="form-check-label" for="directivo">Directivo en una pyme</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="situacion_actual" id="trabajador"
                                    value="2">
                                <label class="form-check-label" for="trabajador">Trabajador en una pyme</label>
                            </div>
                        </fieldset>
                    </div>

                    <!-- Datos Profesionales -->
                    <h2 class="text-center mb-5">Datos Profesionales</h2>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="empresa" class="form-label">Nombre de la Empresa (Razón Social) *</label>
                            <input type="text" class="form-control" id="empresa" name="empresa" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="nif_empresa" class="form-label">NIF Empresa *</label>
                            <input type="text" class="form-control" id="nif_empresa" name="nif_empresa" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <x-select id="actividad_empresa" name="actividad_empresa" label="Actividad de la Empresa *" :options="array_combine(config('options.actividad'), config('options.actividad'))" />
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="tamano_empresa" class="form-label">Tamaño de la Empresa *</label>
                            <select class="form-select" id="tamano_empresa" name="tamano_empresa" required>
                                <option value="">Selecciona</option>
                                <option value="1 - 9 trabajadores">Menos de 10 trabajadores</option>
                                <option value="10 - 49 trabajadores ">10 - 49 trabajadores</option>
                                <option value="50 - 249 trabajadores">50 - 249 trabajadores</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <x-select id="provincia_empresa" name="province" label="Provincia (empresa)" :options="array_combine(config('options.provincias'), config('options.provincias'))" />
                        </div>
                        <div class="col-md-6 mb-4">
                            <x-select id="ccaa" name="ccaa_empresa" label="Comunidad Autónoma (empresa)" :options="array_combine(config('options.ccaa'), config('options.ccaa'))" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="antiguedad_empresa" class="form-label">Antigüedad de la Empresa</label>
                            <select class="form-select" id="antiguedad_empresa" name="antiguedad_empresa">
                                <option value="">Selecciona</option>
                                <option value="Últimos 5 años">Últimos 5 años</option>
                                <option value="De 5 a 10 años">De 5 a 10 años</option>
                                <option value="+ 10 años">Más de 10 años</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="facturacion" class="form-label">Facturación Último Año</label>
                            <select class="form-select" id="facturacion" name="facturacion">
                                <option value="">Selecciona</option>
                                <option value="- De 0 a 500.000€ ">De 0 a 500.000€</option>
                                <option value="- De 500.000 a 1M€ ">De 500.000€ a 1M€</option>
                                <option value="- De 1 a 2 M€ ">De 1M€ a 2M€</option>
                                <option value="- De 2 a 4 M€ ">De 2M€ a 4M€</option>
                                <option value="- + 4 M€ ">Más de 4M€</option>
                            </select>
                        </div>
                    </div>

                    <!-- Radios adicionales -->
                    <div class="mb-3">
                        <fielset id="ambito_rural">
                            <label class="form-label d-block">¿Está ubicada en ámbito rural (menos de 5.000
                                habitantes)?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ambito_rural" id="ambito_rural_si"
                                    value="1">
                                <label class="form-check-label" for="ambito_rural_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ambito_rural" id="ambito_rural_no"
                                    value="2">
                                <label class="form-check-label" for="ambito_rural_no">No</label>
                            </div>
                        </fielset>
                    </div>

                    <div class="mb-3">
                        <fieldset id="politicas_sostenibilidad">
                            <label class="form-label d-block">¿La empresa tiene políticas de sostenibilidad?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="politicas_sostenibilidad"
                                    id="sostenibilidad_si" value="1">
                                <label class="form-check-label" for="sostenibilidad_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="politicas_sostenibilidad"
                                    id="sostenibilidad_no" value="2">
                                <label class="form-check-label" for="sostenibilidad_no">No</label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="mb-3">
                        <fieldset id="transformacion_digital">
                            <label class="form-label d-block">¿La empresa tiene políticas o planes de transformación
                                digital?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="transformacion_digital"
                                    id="transformacion_si" value="1">
                                <label class="form-check-label" for="transformacion_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="transformacion_digital"
                                    id="transformacion_no" value="2">
                                <label class="form-check-label" for="transformacion_no">No</label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="mb-3">
                        <fieldset id="mujer_responsable">
                            <label class="form-label d-block">¿La máxima responsable de la empresa o más del 50% del equipo
                                directivo es mujer?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="mujer_responsable" id="mujer_si"
                                    value="1">
                                <label class="form-check-label" for="mujer_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="mujer_responsable" id="mujer_no"
                                    value="2">
                                <label class="form-check-label" for="mujer_no">No</label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="mb-4">
                        <label for="porcentaje_mujeres" class="form-label">Porcentaje de mujeres con relación laboral
                            con la empresa</label>
                        <select class="form-select" id="porcentaje_mujeres" name="porcentaje_mujeres">
                            <option value="">Selecciona</option>
                            <option value="entre 30% y 50% ">entre 30% y 50%</option>
                            <option value="inferior a 30% ">Menos del 30%</option>
                            <option value="superior a 50% ">Más del 50%</option>
                        </select>
                    </div>

                    <!-- Documentación Adjunta -->
                    <h2 class="text-center mb-5">Documentación Adjunta</h2>
                    <p>* Adjuntar documentación según se indique en las instrucciones de inscripción.</p>

                    <div class="mb-4">
                        <label for="dni_file" class="form-label">Copia del DNI/NIE/Pasaporte/Permiso de Residencia
                            *</label>
                        <input class="form-control" type="file" id="dni_file" name="dni_file" required>
                    </div>

                    <div class="mb-4">
                        <label for="contrato_file" class="form-label">Certificado de Vida laboral</label>
                        <input class="form-control" type="file" id="contrato_file" name="contrato_file">
                    </div>

                    <!-- Declaraciones y Consentimientos -->
                    <h2 class="text-center mb-5">Declaraciones y Consentimientos</h2>

                    <div class="mb-4">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="condiciones" name="condiciones"
                                required>
                            <label class="form-check-label" for="condiciones" data-bs-toggle="collapse"
                                data-bs-target="#condicionesDetalle" style="cursor: pointer;">
                                Acepto los términos del <strong><u>Condicionado</u></strong> General <span
                                    class="text-danger">(obligatorio)</span>
                            </label>
                        </div>

                        <div class="collapse border p-3 rounded bg-white" id="condicionesDetalle">
                            <h5 class="text-success fw-bold mb-3">CONDICIONADO GENERAL CURSO "GENERACIÓN DIGITAL PYMES"
                            </h5>
                            <p>La superación de este programa financiado por el Plan de Recuperación, Transformación y
                                Resiliencia, que imparte <strong>Centro de Formación AFS, S.L</strong> y, en
                                consecuencia, la obtención del Título acreditativo del mismo, están sujetas al
                                cumplimiento de la siguiente condición:</p>
                            <ul>
                                <li>La asistencia a todas las sesiones lectivas del programa es obligatoria y se llevará
                                    registro de ella.</li>
                                <li>El/la participante deberá asistir como mínimo al 75% de las horas de clase
                                    asignadas.</li>
                                <li>En caso de ausencia justificada deberá notificarlo a la entidad organizadora.</li>
                            </ul>
                            <p>Cualquier particularidad se comunicará al inicio del curso.</p>
                        </div>
                    </div>

                    @foreach ([
            'trabaja_en_pyme' => 'Declaro responsablemente que actualmente trabajo en una pyme.',
            'info_veraz' => 'Declaro que toda la información contenida en esta solicitud se corresponde con la realidad.',
            'no_duplicado' => 'Declaro que no he recibido o participado en otra acción formativa de GENERACIÓN DIGITAL PYMES con el mismo contenido.',
            'sin_conflicto' => 'Declaro que no me encuentro en ninguna situación que pueda calificarse de conflicto de interés según normativa vigente.',
            'autorizo_datos' => 'Autorizo tratamiento de datos personales proporcionados para las finalidades descritas.',
            'autorizo_discapacidad' => 'Acepto que el dato relativo a discapacidad sea utilizado con fines estadísticos y de reporte de indicadores a los organismos del PRTR.',
        ] as $name => $label)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="{{ $name }}"
                                name="{{ $name }}" @if ($name !== 'autorizo_discapacidad') required @endif>
                            <label class="form-check-label" for="{{ $name }}">
                                {{ $label }}
                                @if ($name !== 'autorizo_discapacidad')
                                    <span class="text-danger">(obligatorio)</span>
                                @else
                                    <small class="text-muted">(no obligatorio)</small>
                                @endif
                            </label>
                        </div>
                    @endforeach

                    <!-- Información adicional (opcional) -->
                    <div class="mt-3">
                        <small class="text-muted">
                            <strong>* FINALIDAD</strong> del tratamiento de los datos: para gestionar su solicitud de
                            admisión en la actividad formativa seleccionada, así como en su caso la posterior
                            matriculación, gestión, coordinación y celebración del mismo, una vez admitido.
                            En cuanto a los <strong> DESTINATARIOS</strong> de los datos se deberá incorporar que serán
                            cedidos a
                            Fundación EOI F.S.P y a la Secretaría de Estado de Digitalización, así como a los Estados
                            miembros y la Comisión en aplicación de la normativa establecida en el artículo 22 del
                            Reglamento (UE) 2021/241 del Parlamento Europeo y del Consejo, de 12 de febrero de 2021, por
                            el que se establece el Mecanismo de Recuperación y Resiliencia.
                        </small>
                    </div>

                    {{-- Lugar y Fecha --}}
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <label for="lugar" class="form-label">Lugar</label>
                            <input type="text" class="form-control" id="lugar" name="lugar"
                                placeholder="Ciudad">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha">
                        </div>
                    </div>

                    {{-- Firma --}}
                    <div class="container-fluid">

                        <div class="row mt-4">
                            <div class="col-12 px-0">
                                @include('components.sign-canvas')

                            </div>
                        </div>
                    </div>

                    {{-- <!-- Submit --> --}}
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-5 py-2"><strong>Enviar
                                Solicitud</strong></button>
                    </div>

                </div> <!-- /.container-fluid interno -->
            </div> <!-- /.col-xl-8 -->
        </div> <!-- /.row -->
        </div> <!-- /.container-fluid -->
    </form>
@endsection
@push('scripts')
    <script src="{{ asset('js/eoi-form.js') }}"></script>
@endpush
