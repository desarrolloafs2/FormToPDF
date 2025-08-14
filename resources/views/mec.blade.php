@extends('layouts.app')

@section('title', 'Formulario de Participación')
@php
    $educacion = include resource_path('views/options/educacion.php');
    $columns = 2; // Número de columnas deseadas
    $itemsPerCol = ceil(count($educacion) / $columns); // Calcula elementos por columna
    $chunks = array_chunk($educacion, $itemsPerCol, true); // Divide el array en columnas
@endphp
@section('content')
    <h1 class="text-center mb-4">Formulario de Inscripción</h1>

    <form id="{{ $type }}" class="my-5" method="POST" action="{{ url($type) }}" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">

            {{-- Bloque Datos Personales --}}
            <div class="row" id="datosPersonales">
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

                    {{-- Campos Datos Personales --}}
                    <div class="container-fluid">
                        {{-- Apellidos --}}
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-4">
                                <label for="firstSurname" class="form-label">Primer Apellido *</label>
                                <input type="text" class="form-control" id="firstSurname" name="firstSurname" required>
                            </div>
                            <div class="col-lg-6 col-12 mb-4">
                                <label for="apellido2" class="form-label">Segundo Apellido</label>
                                <input type="text" class="form-control" id="apellido2" name="apellido2">
                            </div>
                        </div>

                        {{-- Nombre y género --}}
                        <div class="row">
                            <div class="col-lg-5 col-12 mb-4">
                                <label for="name" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-lg-4 col-12 mb-4">
                                <label for="nif" class="form-label">Documento de Identidad</label>
                                <input type="text" class="form-control" id="nif" name="nif" required>
                            </div>
                            <div class="col-lg-3 col-12 mb-4">
                                <x-select name="sexo" label="Género" :options="array_combine(config('options.sexo'), config('options.sexo'))" required />
                            </div>
                        </div>

                        {{-- Dirección y tipo de vía --}}
                        <div class="row">
                            <div class="col-lg-4 col-12 mb-4">
                                <x-select id="tipo_via" name="tipo_via" label="Tipo de Vía" :options="array_combine(config('options.via'), config('options.via'))" required />
                            </div>
                            <div class="col-lg-8 col-12 mb-4">
                                <label for="direccion" class="form-label">Dirección *</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                            </div>
                        </div>

                        {{-- Ciudad, CP, provincia --}}
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="localidad" class="form-label">Localidad *</label>
                                <input type="text" class="form-control" id="localidad" name="localidad">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="codigo_postal" class="form-label">Código Postal *</label>
                                <input type="text" class="form-control" id="codigo_postal" name="codigo_postal">
                            </div>
                            <div class="col-md-4 mb-4">
                                <x-select id="provincia" name="provincia" label="Provincia*" :options="array_combine(config('options.provincias'), config('options.provincias'))" />
                            </div>
                        </div>

                        {{-- Contacto --}}
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <label for="telefono_movil" class="form-label">Teléfono Móvil *</label>
                                <input type="text" class="form-control" id="telefono_movil" name="telefono" required>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label for="telefono_fijo" class="form-label">Teléfono Fijo</label>
                                <input type="text" class="form-control" id="telefono_fijo" name="telefono_fijo">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label">Correo Electrónico *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        {{-- Otros datos --}}
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-3">
                                <label class="form-label d-block">¿Dispone de Carnet? *</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="carnet" id="carnet_si"
                                        value="si">
                                    <label class="form-check-label" for="carnet_si">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="carnet" id="carnet_no"
                                        value="no">
                                    <label class="form-check-label" for="carnet_no">No</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mb-4">
                                <label for="carnet_tipos" class="form-label">Tipos de Carnet</label>
                                <input type="text" class="form-control" id="carnet_tipos" name="carnet_tipos">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bloque Datos del Representante --}}
            <div class="row">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h2 class="text-center mb-5">Datos del Representante (Opcional)</h2>

                    {{-- Campos del Representante --}}
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="firstSurname_rep" class="form-label">Primer Apellido </label>
                            <input type="text" class="form-control" id="firstSurname_rep" name="firstSurname_rep">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="apellido2_rep" class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" id="apellido2_rep" name="apellido2_rep">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name_rep" class="form-label">Nombre </label>
                            <input type="text" class="form-control" id="name_rep" name="name_rep">
                        </div>
                        <div class="col-md-6 mb-4">
                            <x-select id="tipo_documento_rep" name="tipo_documento_rep" label="Tipo de Documento"
                                :options="array_combine(config('options.dni'), config('options.dni'))" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="nif_rep" class="form-label">Nº de Documento </label>
                            <input type="text" class="form-control" id="nif_rep" name="nif_rep">
                        </div>
                        <div class="col-md-6 mb-4">
                            <x-select name="sexo_rep" label="Género" :options="array_combine(config('options.sexo'), config('options.sexo'))" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <label for="direccion_rep" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion_rep" name="direccion_rep">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="poblacion_rep" class="form-label">Población</label>
                            <input type="text" class="form-control" id="poblacion_rep" name="poblacion_rep">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label for="CP_rep" class="form-label">Código Postal</label>
                            <input type="text" class="form-control" id="CP_rep" name="CP_rep">
                        </div>
                        <div class="col-md-3 mb-4">
                            <x-select id="provincia_rep" name="provincia_rep" label="Provincia*" :options="array_combine(config('options.provincias'), config('options.provincias'))" />
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="email_rep" class="form-label">Correo Electrónico </label>
                            <input type="email" class="form-control" id="email_rep" name="email_rep">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label for="telefono_movil_rep" class="form-label">Teléfono Móvil </label>
                            <input type="text" class="form-control" id="telefono_movil_rep"
                                name="telefono_movil_rep">
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="telefono_fijo_rep" class="form-label">Teléfono Fijo</label>
                            <input type="text" class="form-control" id="telefono_fijo_rep" name="telefono_fijo_rep">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="horario_llamadas" class="form-label">Horario para Contactar</label>
                            <input type="text" class="form-control" id="horario_llamadas" name="horario_llamadas">
                        </div>

                    </div>
                </div>
            </div>

            {{-- Bloque Situación Laboral --}}
            <div class="row" id="situacionLaboral">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h3 class="text-center mb-5">Situación Laboral</h3>
                    @foreach (config('options.situacion_laboral') as $value => $label)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="situacion_laboral"
                                id="situacion_{{ $value }}" value="{{ $value }}">
                            <label class="form-check-label fw-bold"
                                for="situacion_{{ $value }}">{{ $label }}</label>
                        </div>

                        @if ($value === 'desempleado')
                            <div id="situacion_desempleado_group" style="display:none;" class="mt-3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="oficina_empleo" class="form-label">Oficina de empleo</label>
                                        <input type="text" class="form-control" id="oficina_empleo"
                                            name="oficina_empleo" disabled>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_inscripcion" class="form-label">Fecha de inscripción</label>
                                        <input type="date" class="form-control" id="fecha_inscripcion"
                                            name="fecha_inscripcion" disabled>
                                    </div>
                                </div>

                                <label class="form-label">Situación persona desempleada</label>
                                @foreach (config('options.situacion_desempleado') as $key => $desc)
                                    <div class="form-check">
                                        <input class="form-check-input desempleado-radio" type="radio"
                                            id="desempleado_{{ $key }}" name="situacion_desempleado"
                                            value="{{ $key }}" disabled>
                                        <label class="form-check-label" for="desempleado_{{ $key }}">
                                            {{ $desc }}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        @endif

                        @if ($value === 'ocupado')
                            <div id="situacion_ocupado_group" style="display:none;" class="mt-3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="sector" class="form-label">Sector/Comercio</label>
                                        <input type="text" class="form-control" id="sector" name="sector"
                                            disabled>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cif" class="form-label">CIF</label>
                                        <input type="text" class="form-control" id="cif" name="cif"
                                            disabled>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="razon_social" class="form-label">Razón Social</label>
                                    <input type="text" class="form-control" id="razon_social" name="razon_social"
                                        disabled>
                                </div>
                                <div class="row">
                                    <div class="col-md-9 mb-3">
                                        <label for="domicilio_trabajo" class="form-label">Domicilio Centro Trabajo</label>
                                        <input type="text" class="form-control" id="domicilio_trabajo"
                                            name="domicilio_trabajo" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="cp_trabajo" class="form-label">C.P.</label>
                                        <input type="text" class="form-control" id="cp_trabajo" name="cp_trabajo"
                                            disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="localidad_trabajo" class="form-label">Localidad</label>
                                        <input type="text" class="form-control" id="localidad_trabajo"
                                            name="localidad_trabajo" disabled>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <x-select name="regimen_cotización" label="Régimen de Cotización"
                                            :options="array_combine(
                                                config('options.regimen_cotizacion'),
                                                config('options.regimen_cotizacion'),
                                            )" />
                                    </div>


                                </div>

                                <label class="form-label d-block mt-3">Categoría</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        @foreach (array_slice(config('options.categorias'), 0, 4, true) as $key => $desc)
                                            <div class="form-check">
                                                <input class="form-check-input ocupado-checkbox" type="checkbox"
                                                    id="{{ $key }}" name="{{ $key }}" disabled>
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
                                                    value="{{ $key }}" disabled>
                                                <label class="form-check-label" for="{{ $key }}">
                                                    {{ $desc }}
                                                </label>
                                            </div>
                                        @endforeach
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
                    <h3 class="text-center mb-5">Datos Académicos</h3>
                    <label class="form-label mb-1"><strong>Nivel Académico</strong></label>
                    <hr>
                    <div class="row">
                        @foreach ($chunks as $chunk)
                            <div class="col-md-{{ 12 / $columns }}">
                                @foreach ($chunk as $id => $label)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input nivel-academico-radio" type="radio"
                                            id="{{ $id }}" name="nivel_academico"
                                            value="{{ $id }}">
                                        <label class="form-check-label"
                                            for="{{ $id }}">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <label for="especialidad" class="form-label">Especialidad</label>
                        <input type="text" class="form-control" id="especialidad" name="especialidad">
                    </div>
                </div>
            </div>

            {{-- Bloque Idiomas --}}
            {{-- Bloque Idiomas --}}
            <div class="row">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h3 class="text-center mb-5">Idiomas</h3>

                    @foreach (config('options.idiomas') as $index => $idioma)
                        <div class="idioma-group mb-4">
                            <input type="checkbox" id="idioma_{{ $index }}" class="chk-idioma"
                                data-index="{{ $index }}">
                            <label for="idioma_{{ $index }}">{{ $idioma }}</label>

                            {{-- Contenedor de niveles --}}
                            <div class="niveles mt-2" style="display:none;">
                                @foreach (array_merge(config('options.niveles_oficiales'), config('options.niveles_no_oficiales')) as $nivel)
                                    <label class="me-2">
                                        <input type="radio" name="IDIOMA_{{ $index }}"
                                            value="{{ $nivel }}"> {{ $nivel }}
                                    </label>
                                @endforeach
                            </div>

                            {{-- Campo para otro idioma --}}
                            @if ($idioma === 'Otro idioma')
                                <div class="mt-2" id="otro_idioma_container" style="display:none;">
                                    <input type="text" class="form-control" id="otro_idioma" name="OTRO"
                                        placeholder="Especificar idioma" disabled>
                                </div>
                            @endif
                        </div>

                        @if ($index < count(config('options.idiomas')) - 1)
                            <hr>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Bloque Formación Profesional (Cursos realizados anteriormente) --}}
            <div class="row">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h3 class="text-center mb-5">Formación Profesional (Cursos realizados anteriormente)</h3>
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
                                    <td><input type="text" class="form-control" name="curso[]"></td>
                                    <td><input type="text" class="form-control" name="anio[]"></td>
                                    <td><input type="text" class="form-control" name="duracion[]"></td>
                                    <td><input type="text" class="form-control" name="centro[]"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <label class="form-label d-block">¿Está seleccionado/a en otro curso?</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="otro_curso" id="otro_curso_si"
                                value="si">
                            <label class="form-check-label" for="otro_curso_si">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="otro_curso" id="otro_curso_no"
                                value="no" checked>
                            <label class="form-check-label" for="otro_curso_no">No</label>
                        </div>
                    </div>
                    <!-- Campo texto oculto para escribir el curso -->
                    <div class="mt-3" id="otro_curso_text_container" style="display:none;">
                        <label for="otro_curso_text" class="form-label">Indique el nombre del otro curso</label>
                        <input type="text" class="form-control" id="otro_curso_text" name="otro_curso_text"
                            placeholder="Nombre del curso">
                    </div>
                </div>
            </div>

            {{-- Bloque Experiencia Profesional --}}
            <div class="row">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h3 class="text-center mb-5">Experiencia Profesional</h3>
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
                                    <td><input type="text" class="form-control" name="puesto"></td>
                                    <td><input type="text" class="form-control" name="funciones"></td>
                                    <td><input type="text" class="form-control" name="empresa"></td>
                                    <td><input type="text" class="form-control" name="duracion_trabajo"></td>
                                    <td><input type="text" class="form-control" name="sector_anterior"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Bloque Motivos --}}
            <div class="row" id="">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h3 class="text-center mb-5">Motivos para solicitar el Curso</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="motivo_interes"
                                    name="motivo_interes">
                                <label class="form-check-label" for="motivo_interes">Interés</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="motivo_prestacion"
                                    name="motivo_prestacion">
                                <label class="form-check-label" for="motivo_prestacion">No perder la Prestación</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="motivo_cualificacion"
                                    name="motivo_cualificacion">
                                <label class="form-check-label" for="motivo_cualificacion">Mejorar la
                                    Cualificación</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="motivo_trabajo"
                                    name="motivo_trabajo">
                                <label class="form-check-label" for="motivo_trabajo">Encontrar Trabajo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="motivo_sector" name="motivo_sector">
                                <label class="form-check-label" for="motivo_sector">Cambiar de Sector</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="motivo_otros" name="motivo_otros">
                                <label class="form-check-label" for="motivo_otros">Otros</label>
                            </div>
                        </div>
                        <div id="motivos_error"></div>

                    </div>
                </div>
            </div>

            {{-- Bloque Autorizaciones --}}
            <div class="row">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h3 class="text-center mb-4">Autorizaciones</h3>
                    <p>
                        Con la presentación de esta solicitud, y de acuerdo con el artículo 28 de la Ley 39/2015 de 1 de
                        octubre, de Procedimiento Administrativo Común de las Administraciones Públicas, la Subdirección
                        General de Programas y Gestión podrá consultar o recabar documentos elaborados por cualquier
                        Administración salvo que consté en el procedimiento su oposición expresa. En particular se recabarán
                        los siguientes datos salvo que usted marque expresamente:
                    </p>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="oposicion_seguridad_social"
                            name="oposicion_seguridad_social">
                        <label class="form-check-label" for="oposicion_seguridad_social">Me opongo a la consulta de datos
                            acreditativos de Seguridad social (Vida laboral).</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="oposicion_titulacion"
                            name="oposicion_titulacion">
                        <label class="form-check-label" for="oposicion_titulacion">Me opongo a la consulta de datos
                            acreditativos sobre titulación académica.</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="oposicion_identidad"
                            name="oposicion_identidad">
                        <label class="form-check-label" for="oposicion_identidad">Me opongo a la consulta de datos
                            acreditativos de identidad.</label>
                    </div>

                    <p class="mt-3 fst-italic" style="color: darkred;">
                        En el caso de oponerse a la consulta para la comprobación de los datos se compromete a aportar la
                        documentación pertinente.
                    </p>
                </div>
            </div>


            {{-- Bloque LPD --}}
            <div class="row">
                <div
                    class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-12 px-lg-5 px-3 py-4 mb-4 rounded alert alert-light">
                    <h3 class="text-center mb-5">Información de Protección de Datos</h3>
                    <dl class="row">
                        <dt class="col-sm-4">Responsable</dt>
                        <dd class="col-sm-8">Secretaría General de Formación Profesional. C/ Alcalá 34, 28071 Madrid.</dd>

                        <dt class="col-sm-4">Nombre de la actividad</dt>
                        <dd class="col-sm-8">Acciones formativas y seguimiento para la obtención del certificado de
                            profesionalidad.</dd>

                        <dt class="col-sm-4">Finalidad</dt>
                        <dd class="col-sm-8">
                            Gestión de los diferentes procesos y acciones formativas que se desarrollan en el ámbito
                            estatal. Seguimiento.
                        </dd>
                        <dt class="col-sm-4"> Legitimación </dt>
                        <dd class="col-sm-8">
                            La licitud en el tratamiento de los datos se basa en el artículo 6.1 e) del Reglamento (UE)
                            2016/679 y en la Ley 30/2015, de 9 de septiembre, por la que se regula el Sistema de Formación
                            Profesional para el empleo en el ámbito laboral.
                        </dd>
                        <dt class="col-sm-4"> Destinatarios </dt>
                        <dd class="col-sm-8">
                            No hay cesión de datos.
                        </dd>
                        <dt class="col-sm-4"> Periodo de conservación </dt>
                        <dd class="col-sm-8">
                            Los datos se conservarán durante el tiempo necesario para cumplir con la finalidad para la que
                            se recabaron y para determinar las posibles responsabilidades. </dd>
                        <dt class="col-sm-4"> Derechos </dt>
                        <dd class="col-sm-8">
                            Puede ejercitar los derechos de los artículos 15 al 22 del Reglamento, que sean de aplicación de
                            acuerdo a la base jurídica del tratamiento, ante el Delegado de Protección de Datos
                            (dpd@educacion.gob.es). Podrá hacerlo en la sede electrónica asociada del Ministerio,
                            presencialmente en las oficinas de registro o por correo postal.
                        </dd>Asimismo, puede presentar reclamación ante la Agencia Española de Protección de Datos,
                        autoridad de control en materia de protección de datos.(www.aepd.es/es)
                    </dl>
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
                                placeholder="Ciudad">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha">
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
