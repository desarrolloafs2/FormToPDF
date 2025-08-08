@extends('layouts.app')

@section('title', 'Solicitud de Participación')

@section('content')
    <h1 class="text-center mb-4">Solicitud de participación para acciones formativas</h1>

    <form method="POST" action="{{ route('solicitud.store') }}">
        @csrf

        <div class="card p-4 mb-4">
            <h3>Datos de la Persona Solicitante</h3>
            <div class="row">
                <x-input label="NIF/NIE" name="dni" required class="col-md-4" />
                <x-input label="Nombre y Apellidos" name="nombre_apellidos" required class="col-md-8" />
                <x-input label="Dirección" name="direccion" class="col-md-6" />
                <x-input label="Código Postal" name="cp" class="col-md-2" />
                <x-input label="Localidad" name="localidad" class="col-md-4" />
                <x-select label="Provincia" name="provincia" :options="$provincias" class="col-md-6" />
                <x-input label="Fecha de Nacimiento" name="fecha_nacimiento" type="date" class="col-md-6" />
                <x-radio-group label="Sexo" name="sexo" :options="['Hombre', 'Mujer']" />
                <x-input label="Teléfono Móvil" name="telefono_movil" class="col-md-6" />
                <x-input label="Teléfono Fijo" name="telefono_fijo" class="col-md-6" />
                <x-input label="Correo electrónico" name="email" class="col-md-12" />
                <x-checkbox name="tiene_carnet" label="¿Tienes Carnet de Conducir?" />
                <x-input label="Carnets" name="carnets" class="col-md-12" />
            </div>
        </div>

        <div class="card p-4 mb-4">
            <h3>Datos del Representante</h3>
            <div class="row">
                <x-input label="NIF/NIE" name="dni_representante" class="col-md-4" />
                <x-input label="Nombre" name="nombre_representante" class="col-md-8" />
                <x-radio-group label="Sexo" name="sexo_representante" :options="['Hombre', 'Mujer']" />
                <x-input label="1er Apellido" name="apellido1_representante" class="col-md-6" />
                <x-input label="2º Apellido" name="apellido2_representante" class="col-md-6" />
                <x-input label="Domicilio" name="domicilio_representante" class="col-md-12" />
                <x-input label="Provincia" name="provincia_representante" class="col-md-4" />
                <x-input label="C.P." name="cp_representante" class="col-md-4" />
                <x-input label="Población" name="poblacion_representante" class="col-md-4" />
                <x-input label="Teléfono" name="telefono_representante" class="col-md-6" />
                <x-input label="Teléfono Móvil" name="movil_representante" class="col-md-6" />
                <x-input label="Correo Electrónico" name="email_representante" class="col-md-12" />
                <x-input label="Horario preferente para recibir llamada" name="horario_llamada" class="col-md-12" />
            </div>
        </div>

        <div class="card p-4 mb-4">
            <h3>Situación Laboral</h3>
            <x-radio-group name="situacion_laboral" :options="['Trabajador/a desempleado/a', 'Trabajador/a ocupado/a']" />
            <div class="row">
                <x-input label="Oficina de empleo" name="oficina_empleo" class="col-md-6" />
                <x-input label="Fecha de inscripción" name="fecha_inscripcion" type="date" class="col-md-6" />
                <x-checkbox-group label="Situación desempleado/a" name="situacion_desempleado[]" :options="[
                    'Demandantes de primer empleo',
                    'En paro sin prestación o subsidio',
                    'Percibe subsidio por desempleo',
                    'Percibe prestación por desempleo',
                    'Otros no parados/as',
                ]" />
            </div>
        </div>

        <!-- Puedes seguir con más bloques: académicos, idiomas, formación, etc. -->

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-5 py-2">Enviar Solicitud</button>
        </div>
    </form>
@endsection
