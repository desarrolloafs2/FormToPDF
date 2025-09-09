@extends('layouts.app')

@section('title', 'Formulario de Participación')
@php
    $educacion = include resource_path('views/options/educacion.php');
    $columns = 2; // Número de columnas deseadas
    $itemsPerCol = ceil(count($educacion) / $columns); // Calcula elementos por columna
    $chunks = array_chunk($educacion, $itemsPerCol, true); // Divide el array en columnas
@endphp
@section('content')
    <h1 class="text-center mb-4 mt-5">Formulario de Inscripción</h1>

    <form id="{{ $type }}" class="my-5" method="POST" action="{{ url($type) }}" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">

            {{-- Bloque Datos Personales --}}
            <div class="row" id="datosPersonales">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h2 class="form-section-title" class="text-center mb-5">Datos Personales</h2 class="form-section-title">

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
                        {{-- Campos Datos Personales --}}
                        <x-forms.personal-data :isForTesting="$isForTesting" />

                        {{-- Otros datos --}}
                        <div class="row">
                            <div class="col-lg-4 col-12 mb-3">
                                <label class="form-label d-block">¿Dispone de Carnet? *</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="carnet" id="carnet_si"
                                        value="1" @if ($isForTesting) checked @endif>
                                    <label class="form-check-label" for="carnet_si">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="carnet" id="carnet_no"
                                        value="0">
                                    <label class="form-check-label" for="carnet_no">No</label>
                                </div>

                            </div>
                            <div class="col-lg-4 col-12 mb-4">
                                <label for="carnet_tipos" class="form-label">Tipos de Carnet</label>
                                <input type="text" class="form-control" id="carnet_tipos" name="carnet_tipos"
                                    value="{{ $isForTesting ? 'B2' : old('carnet_tipos') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bloque Datos del Representante --}}
            <div class="row">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h2 class="form-section-title" class="text-center mb-5">Datos del Representante (Opcional)</h2
                        class="form-section-title">
                    <x-forms.personal-data :isForTesting="$isForTesting" :isOptional=true />
                </div>
            </div>

            {{-- otros --}}
            <div class="row">
 <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h2 class="form-section-title" class="text-center mb-5">Horario Llamadas</h2
                        class="form-section-title">                    <label for="horario_llamadas" class="form-label">Horario para Contactar</label>
                    <input type="text" class="form-control" id="horario_llamadas" name="horario_llamadas" value="{{ $isForTesting ? 'Mañanas' : old('horario_llamadas') }}">
                </div>
            </div>

            {{-- Bloque Situación Laboral --}}
            <div class="row" id="situacionLaboral">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h2 class="form-section-title text-center mb-5">Situación Laboral</h2>

                    @foreach (config('options.situacion_laboral') as $value => $label)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="situacion_laboral"
                                id="situacion_{{ $value }}" value="{{ $value }}"
                                @if ($isForTesting && $value === 'ocupado') checked @endif>
                            <label class="form-check-label fw-bold"
                                for="situacion_{{ $value }}">{{ $label }}</label>
                        </div>

                        {{-- Bloque desempleado --}}
                        @if ($value === 'desempleado')
                            <div id="situacion_desempleado_group"
                                style="{{ $isForTesting ? 'display:none;' : 'display:none;' }}" class="mt-3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="oficina_empleo" class="form-label">Oficina de empleo</label>
                                        <input type="text" class="form-control" id="oficina_empleo" name="oficina_empleo"
                                            value="{{ $isForTesting ? 'Oficina ejemplo' : old('oficina_empleo') }}"
                                            disabled>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_inscripcion" class="form-label">Fecha de inscripción</label>
                                        <input type="date" class="form-control" id="fecha_inscripcion"
                                            name="fecha_inscripcion"
                                            value="{{ $isForTesting ? now()->format('Y-m-d') : old('fecha_inscripcion') }}"
                                            disabled>
                                    </div>
                                </div>

                                <label class="form-label">Situación persona desempleada</label>
                                @foreach (config('options.situacion_desempleado') as $key => $desc)
                                    <div class="form-check">
                                        <input class="form-check-input desempleado-radio" type="radio"
                                            id="desempleado_{{ $key }}" name="situacion_desempleado"
                                            value="{{ $key }}" @if ($isForTesting && $loop->first) checked @endif
                                            disabled>
                                        <label class="form-check-label" for="desempleado_{{ $key }}">
                                            {{ $desc }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Bloque ocupado --}}
                        @if ($value === 'ocupado')
                            <div id="situacion_ocupado_group" style="{{ $isForTesting ? '' : 'display:none;' }}"
                                class="mt-3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="sector" class="form-label">Sector/Comercio</label>
                                        <input type="text" class="form-control" id="sector" name="sector"
                                            value="{{ $isForTesting ? 'Comercio' : old('sector') }}" disabled>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cif" class="form-label">CIF</label>
                                        <input type="text" class="form-control" id="cif" name="cif"
                                            value="{{ $isForTesting ? 'A12345678' : old('cif') }}" disabled>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="razon_social" class="form-label">Razón Social</label>
                                    <input type="text" class="form-control" id="razon_social" name="razon_social"
                                        value="{{ $isForTesting ? 'Empresa Ejemplo S.A.' : old('razon_social') }}"
                                        disabled>
                                </div>

                                <div class="row">
                                    <div class="col-md-9 mb-3">
                                        <label for="domicilio_trabajo" class="form-label">Domicilio Centro Trabajo</label>
                                        <input type="text" class="form-control" id="domicilio_trabajo"
                                            name="domicilio_trabajo"
                                            value="{{ $isForTesting ? 'Calle Falsa 123' : old('domicilio_trabajo') }}"
                                            disabled>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="cp_trabajo" class="form-label">C.P.</label>
                                        <input type="text" class="form-control" id="cp_trabajo" name="cp_trabajo"
                                            value="{{ $isForTesting ? '28001' : old('cp_trabajo') }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="localidad_trabajo" class="form-label">Localidad</label>
                                        <input type="text" class="form-control" id="localidad_trabajo"
                                            name="localidad_trabajo"
                                            value="{{ $isForTesting ? 'Madrid' : old('localidad_trabajo') }}" disabled>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <x-select name="regimen_cotización" label="Régimen de Cotización"
                                            :options="array_combine(
                                                config('options.regimen_cotizacion'),
                                                config('options.regimen_cotizacion'),
                                            )" :selected="$isForTesting
                                                ? config('options.regimen_cotizacion')['RG']
                                                : old('regimen_cotizacion')" />
                                    </div>
                                </div>

                                <label class="form-label d-block mt-3">Categoría</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        @foreach (array_slice(config('options.categorias'), 0, 4, true) as $key => $desc)
                                            <div class="form-check">
                                                <input class="form-check-input ocupado-checkbox" type="checkbox"
                                                    id="{{ $key }}" name="{{ $key }}"
                                                    @if ($isForTesting && $loop->first) checked @endif disabled>
                                                <label class="form-check-label"
                                                    for="{{ $key }}">{{ $desc }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-6">
                                        @foreach (array_slice(config('options.categorias'), 4, null, true) as $key => $desc)
                                            <div class="form-check">
                                                <input class="form-check-input ocupado-radio" type="radio"
                                                    id="{{ $key }}" name="categoria"
                                                    value="{{ $key }}"
                                                    @if ($isForTesting && $loop->first) checked @endif disabled>
                                                <label class="form-check-label"
                                                    for="{{ $key }}">{{ $desc }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="form-label d-block">¿Empresa de más de 250 trabajadores? *</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="empresa_250_si"
                                            name="empresa_mas_250" value="On"
                                            @if ($isForTesting) checked @endif disabled>
                                        <label class="form-check-label" for="empresa_250_si">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="empresa_250_no"
                                            name="empresa_mas_250" value="" disabled>
                                        <label class="form-check-label" for="empresa_250_no">No</label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <hr>
                    @endforeach
                </div>
            </div>

            {{-- Bloque Datos Académicos --}}
            <div class="row">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h2 class="form-section-title text-center mb-5">Datos Académicos</h2>
                    <div class="row">
                        <div class="col-md-5 mb-5">
                            <label for="nivel_academico" class="form-label mb-3 fw-bold">Nivel Académico</label>
                            <x-select name="nivel_academico" label="" :options="config('options.nivel_academico')" :selected="$isForTesting ? 'eso' : old('nivel_academico')" />
                        </div>
                        <div class="col-md-7 mb-5">
                            <label for="especialidad" class="form-label mb-3 fw-bold">Especialidad</label>
                            <input type="text" class="form-control" id="especialidad" name="especialidad"
                                value="{{ $isForTesting ? 'Administración' : old('especialidad') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bloque Idiomas --}}
            <div class="row">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h2 class="form-section-title text-center mb-5">Idiomas</h2>

                    @foreach (config('options.idiomas') as $index => $idioma)
                        @php $key = $index + 1; @endphp
                        <div class="idioma-group mb-4">
                            {{-- Checkbox del idioma --}}
                            <input type="checkbox" id="idioma_{{ $key }}" class="chk-idioma"
                                name="{{ $idioma }}" value="1" data-index="{{ $key }}"
                                @if ($isForTesting) checked @endif>
                            <label for="idioma_{{ $key }}" class="fw-bold">{{ $idioma }}</label>
                            {{-- Contenedor de niveles --}}
                            <div class="niveles mt-2" style="display:none;">
                                {{-- Niveles oficiales --}}
                                <div class="mb-2">
                                    <span class="d-block small text-muted">Niveles oficiales</span>
                                    @foreach (config('options.niveles_oficiales') as $nivel)
                                        <label class="me-2">
                                            <input type="radio" name="{{ $nivel }}" value="1" disabled
                                                @if ($isForTesting && $loop->first) checked @endif>
                                            {{ $nivel }}
                                        </label>
                                    @endforeach
                                </div>
                                {{-- Niveles no oficiales --}}
                                <div>
                                    <span class="d-block small text-muted">Niveles no oficiales</span>
                                    @foreach (config('options.niveles_no_oficiales') as $nivel)
                                        <label class="me-2">
                                            <input type="radio" name="{{ $nivel }}" value="1" disabled>
                                            {{ $nivel }}
                                        </label>
                                    @endforeach
                                </div>

                                <div class="idioma-error text-danger mt-1"></div>
                            </div>
                            {{-- Campo extra para "Otro idioma" --}}
                            @if ($idioma === 'OTRO')
                                <div class="mt-2" id="otro_idioma_container" style="display:;">
                                    <input type="text" class="form-control" id="otro_idioma" name="OTRO"
                                        placeholder="Especificar idioma"
                                        value="{{ $isForTesting ? 'Latín' : old('OTRO') }}" disabled>
                                </div>
                            @endif
                        </div>

                        @if ($index < count(config('options.idiomas')) - 1)
                            <hr>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Bloque Formación Profesional --}}
            <div class="row">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h2 class="form-section-title text-center mb-5">Formación Profesional</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Denominación Curso</th>
                                    <th>Año</th>
                                    <th>Duración (Horas)</th>
                                    <th>Centro</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" name="curso[]"
                                            value="{{ $isForTesting ? 'Excel Avanzado' : old('curso.0') }}"></td>
                                    <td><input type="text" class="form-control" name="anio[]"
                                            value="{{ $isForTesting ? '2024' : old('anio.0') }}"></td>
                                    <td><input type="text" class="form-control" name="duracion[]"
                                            value="{{ $isForTesting ? '20' : old('duracion.0') }}"></td>
                                    <td><input type="text" class="form-control" name="centro[]"
                                            value="{{ $isForTesting ? 'Centro Ejemplo' : old('centro.0') }}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mb-3" id="otro_curso">
                        <div class="col-md-4 d-flex align-items-center">
                            <label for="otro_curso" class="form-label mb-0">¿Está matriculado en otro curso?
                                ¿Cuál?</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="otro_curso" name="otro_curso"
                                placeholder="Nombre del curso"
                                value="{{ $isForTesting ? 'Curso de Liderazgo' : old('otro_curso') }}">
                        </div>
                    </div>
                </div>

                {{-- Bloque Experiencia Profesional --}}
                <div class="row">
                    <div
                        class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                        <h2 class="form-section-title text-center mb-5">Experiencia Profesional</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Puesto</th>
                                        <th>Funciones</th>
                                        <th>Empresa </th>
                                        <th>Duración (años)</th>
                                        <th>Sector</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" class="form-control" name="puesto"
                                                value="{{ $isForTesting ? 'Analista' : old('puesto') }}"></td>
                                        <td><input type="text" class="form-control" name="funciones"
                                                value="{{ $isForTesting ? 'Análisis de datos' : old('funciones') }}"></td>
                                        <td><input type="text" class="form-control" name="empresa"
                                                value="{{ $isForTesting ? 'Empresa Ejemplo' : old('empresa') }}"></td>
                                        <td><input type="text" class="form-control" name="duracion_trabajo"
                                                value="{{ $isForTesting ? '2' : old('duracion_trabajo') }}"></td>
                                        <td><input type="text" class="form-control" name="sector_anterior"
                                                value="{{ $isForTesting ? 'Tecnología' : old('sector_anterior') }}"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Bloque Motivos --}}
                <div class="row" id="motivos">
                    <div
                        class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                        <h2 class="form-section-title text-center mb-5">Motivos para solicitar el Curso</h2>
                        <div class="row">
                            <x-checkbox-group name="motivos" config-key="options.motivo_participacion"
                                label="Motivos para solicitar el Curso" :columns="2" :selected="$isForTesting ? array_keys(config('options.motivo_participacion')) : []" />

                        </div>
                        <div id="motivos_error"></div>
                    </div>
                </div>

                {{-- Bloque Autorizaciones --}}
                <div class="row" id="autorizaciones">
                    <div
                        class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                        <h2 class="form-section-title text-center mb-5">Autorizaciones</h2>

                        {{-- Texto legal antes de los checks --}}
                        <p class="mb-4">
                            {{ config('declaraciones.autorizaciones') }}
                        </p>

                        <div class="row">
                            <x-checkbox-group name="autorizaciones" config-key="options.autorizaciones"
                                label="Autorizaciones" :columns="1" :selected="$isForTesting ? array_keys(config('options.autorizaciones')) : []" />
                        </div>

                        {{-- Texto informativo bajo los checks --}}
                        <p class="mt-3 text-danger fst-italic">
                            {{ config('declaraciones.no_autoriza') }}
                        </p>
                    </div>
                </div>

                {{-- Lugar y Fecha --}}
                <div class="row">
                    <div
                        class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <label for="lugar" class="form-label">Lugar</label>
                                <input type="text" class="form-control" id="lugar" name="lugar"
                                    placeholder="Ciudad" value="{{ $isForTesting ? 'Madrid' : old('lugar') }}">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha" name="fecha"
                                    value="{{ $isForTesting ? now()->format('Y-m-d') : old('fecha') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Firma --}}
                <div class="row" id="signature">
                    <div
                        class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                        @include('components.sign-canvas')

                    </div>
                </div>
            </div>

            {{-- Botón de envío --}}
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2">Enviar Solicitud</button>
            </div>
        </div>
    </form>
@endsection
@push('scripts')
    <script src="{{ asset('js/mec-form.js') }}"></script>
@endpush
