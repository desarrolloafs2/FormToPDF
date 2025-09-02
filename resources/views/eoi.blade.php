@extends('layouts.app')

@section('title', 'Formulario de Inscripción')

@section('content')
    <h1 class="mb-4 text-center mt-5">Formulario de Inscripción</h1>

    <form id="{{ $type }}" class="my-5" method="POST" action="{{ url($type) }}" enctype="multipart/form-data">
        @csrf

        <div class="container-fluid">
            <div class="row">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h2 class="form-section-title">Datos Personales</h2>

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
                                <label for="firstSurname" class="form-label">Primer Apellido</label>
                                <input type="text" class="form-control" id="firstSurname" name="firstSurname"
                                    value="{{ $isForTesting ? 'Pérez' : old('firstSurname') }}" required>
                            </div>
                            <div class="col-lg-6 col-12 mb-4">
                                <label for="apellido2" class="form-label">Segundo Apellido</label>
                                <input type="text" class="form-control" id="apellido2" name="apellido2"
                                    value="{{ $isForTesting ? 'Gómez' : old('apellido2') }}">
                            </div>
                        </div>

                        <!-- Nombre y tipo de documento -->
                        <div class="row">
                            <div class="col-lg-5 col-12 mb-4">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $isForTesting ? 'Juan' : old('name') }}" required>
                            </div>
                            <div class="col-lg-2 col-12 mb-4">
                                <x-select id="tipo_documento" name="tipo_documento" label="Tipo de Documento"
                                    :options="array_combine(config('options.dni'), config('options.dni'))" :selected="$isForTesting ? 'NIF' : old('tipo_documento')" required />
                            </div>
                            <div class="col-lg-5 col-12 mb-4">
                                <label for="nif" class="form-label">Nº de Documento</label>
                                <input type="text" class="form-control" id="nif" name="nif"
                                    value="{{ $isForTesting ? '54078631L' : old('nif') }}" required>
                            </div>
                        </div>

                        <!-- sexo, Fecha y dirección -->
                        <div class="row">
                            <div class="col-lg-3 col-12 mb-4">
                                <x-select name="sexo" label="Género" :options="array_combine(config('options.sexo'), config('options.sexo'))" :selected="$isForTesting ? 'M' : old('sexo')" required />
                            </div>
                            <div class="col-lg-3 col-12 mb-4">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                                    value="{{ $isForTesting ? '1990-01-01' : old('fecha_nacimiento') }}">
                            </div>
                            <div class="col-lg-6 col-12 mb-4">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion"
                                    value="{{ $isForTesting ? 'Calle Falsa 123' : old('direccion') }}">
                            </div>
                        </div>

                        <!-- Ciudad, CP, provincia, CCAA -->
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <label for="ciudad" class="form-label">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" name="ciudad"
                                    value="{{ $isForTesting ? 'Madrid' : old('ciudad') }}">
                            </div>
                            <div class="col-md-3 mb-4">
                                <label for="codigo_postal" class="form-label">Código Postal</label>
                                <input type="text" class="form-control" id="codigo_postal" name="codigo_postal"
                                    value="{{ $isForTesting ? '28001' : old('codigo_postal') }}">
                            </div>
                            <div class="col-md-3 mb-4">
                                <x-select id="provincia" name="provincia" label="Provincia" :options="array_combine(config('options.provincias'), config('options.provincias'))"
                                    :selected="$isForTesting ? 'Madrid' : old('provincia')" />
                            </div>
                            <div class="col-md-3 mb-4">
                                <x-select name="ccaa" label="Comunidad Autónoma" :options="array_combine(config('options.ccaa'), config('options.ccaa'))" :selected="$isForTesting ? 'Comunidad de Madrid' : old('ccaa')"
                                    required />
                            </div>
                        </div>

                        <!-- Contacto -->
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <label for="telefono" class="form-label">Teléfono Móvil</label>
                                <input type="text" class="form-control" id="telefono" name="telefono"
                                    value="{{ $isForTesting ? '600123456' : old('telefono') }}" required>
                            </div>
                            <div class="col-md-5 mb-4">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $isForTesting ? 'juan@example.com' : old('email') }}" required>
                            </div>
                            <div class="col-md-4 mb-6"></div>
                        </div>

                        <!-- Información Adicional -->
                        <h2 class="form-section-title text-center mb-5 mt-5">Información Adicional</h2>
                        <div class="row">
                            <!-- Discapacidad -->
                            <div class="col-md-5 mb-5">
                                <fieldset id="discapacidad">
                                    <label class="form-label d-block">¿Persona con discapacidad?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="discapacidad"
                                            id="discapacidad" value="1"
                                            {{ ($isForTesting ? 'checked' : old('discapacidad')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="discapacidad">¿Persona con
                                            discapacidad?</label>
                                    </div>
                                </fieldset>
                            </div>

                            <!-- Reside en localidad menor de 5000 -->
                            <div class="col-md-7 mb-5">
                                <fieldset id="reside_en_localidad_menor_5000">
                                    <label class="form-label d-block">¿Reside en una localidad con menos de 5.000
                                        habitantes?</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            name="reside_en_localidad_menor_5000" id="reside_si" value="1"
                                            {{ ($isForTesting ? 'checked' : old('reside_en_localidad_menor_5000') == 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="reside_si">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            name="reside_en_localidad_menor_5000" id="reside_no" value="2"
                                            {{ ($isForTesting ? '' : old('reside_en_localidad_menor_5000') == 2) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="reside_no">No</label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <!-- Nivel de estudios -->
                        <div class="row">
                            <div class="col-md-5 mb-4">
                                <x-select id="nivel_estudios" name="nivel_estudios" label="Nivel de Estudios Finalizado"
                                    :options="array_combine(config('options.cine'), config('options.cine'))" :selected="$isForTesting ? 'CINE 1: Enseñanza primaria' : old('nivel_estudios')" />
                            </div>
                            <div class="col-md-7 mb-4">
                                <label for="titulacion" class="form-label">Titulación</label>
                                <input type="text" class="form-control" id="titulacion" name="titulacion"
                                    value="{{ $isForTesting ? 'Bachillerato' : old('titulacion') }}">
                            </div>
                        </div>

                        <!-- Datos Profesionales -->
                        <h2 class="form-section-title text-center mb-5 mt-5">Datos Profesionales</h2>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <fieldset id="situacion_actual" class="form-group">
                                    <label class="form-label px-2">Situación Laboral Actual</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="situacion_actual"
                                            id="empleado" value="1"
                                            {{ ($isForTesting ? 'checked' : old('situacion_actual') == 1) ? 'checked' : '' }}
                                            required>
                                        <label class="form-check-label" for="empleado">Empleado/a por cuenta ajena</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="situacion_actual"
                                            id="autonomo" value="2"
                                            {{ ($isForTesting ? '' : old('situacion_actual') == 2) ? 'checked' : '' }}
                                            required>
                                        <label class="form-check-label" for="autonomo">Autónomo/a - empresario/a</label>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-6 mb-4">
                                <fieldset id="relacion_empresa" class="form-group">
                                    <label class="form-label px-2">Relación con la Empresa</label>
                                    @foreach (config('options.relacion_empresa') as $value => $label)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="relacion_empresa"
                                                id="relacion_empresa_{{ $value }}" value="{{ $value }}"
                                                required
                                                @if ($isForTesting && $value == 1) checked
                       @elseif(old('relacion_empresa') == $value)
                           checked @endif>
                                            <label class="form-check-label" for="relacion_empresa_{{ $value }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    @endforeach
                                </fieldset>
                            </div>

                        </div>

                        <!-- Empresa y Pyme -->
                        <h5 class="form-section-subtitle">Para Trabajadores por cuenta ajena (Todo Tipo de Empresas)</h5>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="empresa" class="form-label">Nombre de la Empresa</label>
                                <input type="text" class="form-control" id="empresa" name="empresa"
                                    value="{{ $isForTesting ? 'Empresa Prueba S.A.' : old('empresa') }}" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="nif_empresa" class="form-label">CIF Empresa</label>
                                <input type="text" class="form-control" id="nif_empresa" name="nif_empresa"
                                    value="{{ $isForTesting ? 'B12345674' : old('nif_empresa') }}" required>
                            </div>
                        </div>

                        <h5 class="form-section-subtitle">Para Trabajadores de Pymes (Autónomos Incluidos)</h5>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <x-select id="actividad_empresa" name="actividad_empresa" label="Actividad de la Empresa"
                                    :options="array_combine(config('options.actividad'), config('options.actividad'))" :selected="$isForTesting
                                        ? 'C. - Industria manufacturera'
                                        : old('actividad_empresa')" />
                            </div>
                            <div class="col-md-6 mb-4">
                                <x-select id="facturacion" name="facturacion" label="Facturación Último Año"
                                    :options="array_combine(
                                        config('options.facturacion'),
                                        config('options.facturacion'),
                                    )" :selected="$isForTesting ? '500.000 - 1M€' : old('facturacion')" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <x-select id="tamano_empresa" name="tamano_empresa" label="Tamaño de la Empresa"
                                    :options="array_combine(
                                        config('options.tamano_empresa'),
                                        config('options.tamano_empresa'),
                                    )" :selected="$isForTesting ? '50 - 249 trabajadores' : old('tamano_empresa')" required />
                            </div>
                            <div class="col-md-6 mb-4">
                                <x-select id="provincia_empresa" name="province" label="Provincia (empresa)"
                                    :options="array_combine(
                                        config('options.provincias'),
                                        config('options.provincias'),
                                    )" :selected="$isForTesting ? 'Madrid' : old('province')" />
                            </div>
                        </div>
                        <div class="row">
                            {{-- Comunidad Autónoma --}}
                            <div class="col-md-6 mb-4">
                                <x-select id="ccaa" name="ccaa_empresa" label="Comunidad Autónoma (empresa)"
                                    :options="array_combine(config('options.ccaa'), config('options.ccaa'))" :selected="$isForTesting ? 'Comunidad de Madrid' : old('ccaa_empresa')" required />
                            </div>

                            {{-- Antigüedad --}}
                            <div class="col-md-6 mb-4">
                                <x-select id="antiguedad_empresa" name="antiguedad_empresa"
                                    label="Antigüedad de la Empresa" :options="array_combine(
                                        config('options.antiguedad_empresa'),
                                        config('options.antiguedad_empresa'),
                                    )" :selected="$isForTesting ? '+10 años' : old('antiguedad_empresa')" required />
                            </div>
                        </div>

                        <!-- Radios adicionales -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <fieldset id="politicas_sostenibilidad">
                                    <label class="form-label d-block">¿La empresa tiene políticas de
                                        sostenibilidad?</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="politicas_sostenibilidad"
                                            id="sostenibilidad_si" value="1"
                                            {{ ($isForTesting ? 'checked' : old('politicas_sostenibilidad') == 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sostenibilidad_si">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="politicas_sostenibilidad"
                                            id="sostenibilidad_no" value="2"
                                            {{ ($isForTesting ? '' : old('politicas_sostenibilidad') == 2) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sostenibilidad_no">No</label>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-6 mb-4">
                                <fieldset id="transformacion_digital">
                                    <label class="form-label d-block">¿La empresa tiene políticas o planes de
                                        transformación digital?</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="transformacion_digital"
                                            id="transformacion_si" value="1"
                                            {{ ($isForTesting ? 'checked' : old('transformacion_digital') == 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="transformacion_si">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="transformacion_digital"
                                            id="transformacion_no" value="2"
                                            {{ ($isForTesting ? '' : old('transformacion_digital') == 2) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="transformacion_no">No</label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <fieldset id="mujer_responsable">
                                    <label class="form-label d-block">¿La máxima responsable de la empresa o más del 50%
                                        del equipo directivo es mujer?</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="mujer_responsable"
                                            id="mujer_si" value="1"
                                            {{ ($isForTesting ? 'checked' : old('mujer_responsable') == 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mujer_si">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="mujer_responsable"
                                            id="mujer_no" value="2"
                                            {{ ($isForTesting ? '' : old('mujer_responsable') == 2) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mujer_no">No</label>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="porcentaje_mujeres" class="form-label">Porcentaje de mujeres con relación
                                    laboral con la empresa</label>
                                <select class="form-select" id="porcentaje_mujeres" name="porcentaje_mujeres">
                                    <option value="">Selecciona</option>
                                    <option value="Entre 30% y 50%"
                                        {{ ($isForTesting ? 'selected' : old('porcentaje_mujeres') == 'entre 30% y 50%') ? 'selected' : '' }}>
                                        entre 30% y 50%</option>
                                    <option value="Inferior a 30%"
                                        {{ ($isForTesting ? '' : old('porcentaje_mujeres') == 'inferior a 30%') ? 'selected' : '' }}>
                                        Menos del 30%</option>
                                    <option value="Superior al 50%"
                                        {{ ($isForTesting ? '' : old('porcentaje_mujeres') == 'superior a 50%') ? 'selected' : '' }}>
                                        Más del 50%</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <fieldset id="ambito_rural">
                                    <label class="form-label d-block">¿Está ubicada en ámbito rural (menos de 5.000
                                        habitantes)?</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ambito_rural"
                                            id="ambito_rural_si" value="1"
                                            {{ ($isForTesting ? 'checked' : old('ambito_rural') == 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ambito_rural_si">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ambito_rural"
                                            id="ambito_rural_no" value="2"
                                            {{ ($isForTesting ? '' : old('ambito_rural') == 2) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ambito_rural_no">No</label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <!-- Documentación Adjunta -->
                        <h2 class="form-section-title">Documentación Adjunta</h2>
                        <p>Adjuntar documentación según se indique en las instrucciones de inscripción.</p>

                        <!-- Declaraciones y Consentimientos -->
                        <h2 class="form-section-title">Declaraciones y Consentimientos</h2>
                        <div class="mb-4">
                            {{-- Condicionado General --}}
                            <x-checkbox-colapsable id="condiciones" label="Acepto los términos del Condicionado General"
                                :required="true" :checked="$isForTesting">
                                <h5 class="text-success fw-bold mb-3">{{ config('declaraciones.condiciones.titulo') }}
                                </h5>
                                <p>{{ config('declaraciones.condiciones.introduccion') }}</p>
                                <ul>
                                    @foreach (config('declaraciones.condiciones.puntos') as $punto)
                                        <li>{{ $punto }}</li>
                                    @endforeach
                                </ul>
                            </x-checkbox-colapsable>

                            {{-- Checkboxes simples y colapsables --}}
                            @foreach (config('declaraciones.checkboxes') as $name => $label)
                                @if ($name === 'autorizo_datos')
                                    <x-checkbox-colapsable id="autorizo_datos"
                                        label="Autorizo tratamiento de datos personales" :required="true"
                                        :checked="$isForTesting">
                                        <small class="text-muted">
                                            {{ config('declaraciones.informacion_adicional') }}
                                        </small>
                                    </x-checkbox-colapsable>
                                @else
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="{{ $name }}"
                                            name="{{ $name }}" @if ($isForTesting) checked @endif
                                            @if ($name !== 'autorizo_discapacidad') required @endif>
                                        <label class="form-check-label" for="{{ $name }}">
                                            {{ $label }}
                                            @if ($name !== 'autorizo_discapacidad')
                                                <span class="text-danger">(obligatorio)</span>
                                            @else
                                                <span class="text-danger">(no obligatorio)</span>
                                            @endif
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        {{-- Lugar y Fecha --}}
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <label for="lugar" class="form-label">Lugar</label>
                                <input type="text" class="form-control" id="lugar" name="lugar"
                                    value="{{ $isForTesting ? 'Madrid' : old('lugar') }}" placeholder="Ciudad">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha" name="fecha"
                                    value="{{ $isForTesting ? date('Y-m-d') : old('fecha') }}">
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

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">
                                <span class="btn-text"><strong>Enviar Solicitud</strong></span>
                                <span class="spinner" style="display:none; margin-left:8px;">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="animate-spin">
                                        <circle cx="12" cy="12" r="10" stroke-width="4"
                                            class="opacity-25" />
                                        <path fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                            class="opacity-75" />
                                    </svg>
                                </span>
                            </button>
                        </div>

                        @push('scripts')
                            <script src="{{ asset('js/eoi-form.js') }}"></script>
                        @endpush
