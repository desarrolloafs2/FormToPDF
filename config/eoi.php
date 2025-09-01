<?php

return [

    // Map de campos personales
    'personal_fields' => [
        'Primer Apellido' => 'firstSurname',
        'Segundo Apellido' => 'apellido2',
        'Nombre' => 'name',
        'Seleccionar NIF/NIE/PASS' => 'tipo_documento',
        'Nº documento' => 'nif',
        'Seleccionar M/F/NB' => 'sexo',
        '(aaaa/mm/dd)' => 'fecha_nacimiento',
        'Dirección' => 'direccion',
        'Ciudad' => 'ciudad',
        'Código postal' => 'codigo_postal',
        'Provincia' => 'provincia',
        'ccaa' => 'ccaa',
        'Teléfono' => 'telefono',
        'email' => 'email',
        'Titulación' => 'titulacion',
    ],

    'reside_en_localidad_menor_5000' => [
        'sí' => 'Check Box38',
        'no' => 'Check Box39',
    ],

    'discapacidad' => 'Check Box40',

    // === RADIO GROUP ===
    'nivel_estudios' => [
        'CINE 1: Enseñanza primaria' => 'Check Box22',
        'CINE 2: Primer Ciclo de Enseñanza Secundaria: ESO o equivalente' => 'Check Box23',
        'CINE 3: Segundo Ciclo de Enseñanza Secundaria: FP Básica, FP Grado Medio, Bachillerato' => 'Check Box24',
        'CINE 4: Enseñanza Postsecundaria no Terciaria' => 'Check Box25',
        'CINE 5 a 7: Estudios Universitarios y FP Grado Superior o equivalente' => 'Check Box41',
        'Ninguna de las anteriores' => 'Check Box32',
    ],

    'situacion_actual' => [
        'Empleado/a por cuenta ajena' => 'Check Box42',
        'Autónomo/a - empresario/a' => 'Check Box43',
    ],

    'relacion_empresa' => [
        'Directivo/a miembro del Comité de Dirección' => 'Check Box46',
        'Relación con el capital de la empresa (socio, hijo...)' => 'Check Box47',
        'Responsable de un área/departamento de la empresa' => 'Check Box48',
        'Trabajador/a de la empresa' => 'Check Box51',
    ],

    // Map de campos de empresa
    'company_fields' => [
        'Nombre empresa (razón social)' => 'empresa',
        'NIF Empresa' => 'nif_empresa',
        'Letra CNAE' => 'actividad_empresa',
        'PROVINCIA EMPRESA' => 'ccaa_empresa',
        'CCAA EMPRESA' => 'province',
    ],

    'tamano_empresa' => [
        '1 - 9 trabajadores' => 'Check Box3',
        '10 - 49 trabajadores' => 'Check Box7',
        '50 - 249 trabajadores' => 'Check Box8',
    ],

    'antiguedad_empresa' => [
        'Últimos 5 años' => 'Check Box9',
        'De 5 a 10 años' => 'Check Box10',
        '+10 años' => 'Check Box11',
    ],

    'facturacion' => [
        '0 - 500.000€' => 'Check Box12',
        '500.000 - 1M€' => 'Check Box13',
        '1 - 2 M€' => 'Check Box14',
        '2 - 4 M€' => 'Check Box15',
        '+ 4 M€' => 'Check Box16',
    ],

    'ambito_rural' => [
        'sí' => 'Check Box17',
        'no' => 'Check Box18',
    ],

    'politicas_sostenibilidad' => [
        'sí' => 'Check Box19',
        'no' => 'Check Box20',
    ],

    'transformacion_digital' => [
        'sí' => 'Check Box21',
        'no' => 'Check Box26',
    ],

    'mujer_responsable' => [
        'sí' => 'Check Box27',
        'no' => 'Check Box28',
    ],

    'porcentaje_mujeres' => [
        'Inferior a 30%' => 'Check Box29',
        'Entre 30% y 50%' => 'Check Box30',
        'Superior al 50%' => 'Check Box31',
    ],

    'consentimientos' => [
        'trabaja_en_pyme' => 'Check Box1',
        'info_veraz' => 'Check Box2',
        'no_duplicado' => 'Check Box4',
        'sin_conflicto' => 'Check Box5',
        'autorizo_datos' => 'Check Box6',
        'autorizo_discapacidad' => 'Check Box36',
        'condiciones' => 'Check Box37',
    ],

    'lugar' => 'lugar',
    'fecha' => 'fecha_hoy',
    'signature' => 'signature',

    'option_groups' => [
        'reside_en_localidad_menor_5000',
        'nivel_estudios',   
        'situacion_actual',
        'relacion_empresa',
        'tamano_empresa',
        'antiguedad_empresa',
        'facturacion',
        'porcentaje_mujeres',
        'ambito_rural',
        'politicas_sostenibilidad',
        'transformacion_digital',
        'mujer_responsable',
    ],

    /*
     * === MAPPINGS ===
     */
    'mappings' => [

        'reside_en_localidad_menor_5000' => [
            1 => 'sí',
            0 => 'no',
        ],

        // 👇 mapeo limpio hacia las opciones del radio
        'nivel_estudios' => [
            1 => 'CINE 1: Enseñanza primaria',
            2 => 'CINE 2: Primer Ciclo de Enseñanza Secundaria: ESO o equivalente',
            3 => 'CINE 3: Segundo Ciclo de Enseñanza Secundaria: FP Básica, FP Grado Medio, Bachillerato',
            4 => 'CINE 4: Enseñanza Postsecundaria no Terciaria',
            5 => 'CINE 5 a 7: Estudios Universitarios y FP Grado Superior o equivalente',
            0 => 'Ninguna de las anteriores',
        ],

        'situacion_actual' => [
            1 => 'Empleado/a por cuenta ajena',
            2 => 'Autónomo/a - empresario/a',
        ],

        'relacion_empresa' => [
            1 => 'Directivo/a miembro del Comité de Dirección',
            2 => 'Relación con el capital de la empresa (socio, hijo...)',
            3 => 'Responsable de un área/departamento de la empresa',
            4 => 'Trabajador/a de la empresa',
        ],

        'tamano_empresa' => [
            '1' => '1 - 9 trabajadores',
            '2' => '10 - 49 trabajadores',
            '3' => '50 - 249 trabajadores',
        ],

        'antiguedad_empresa' => [
            1 => 'Últimos 5 años',
            2 => 'De 5 a 10 años',
            3 => '+10 años',
        ],

        'facturacion' => [
            1 => '0 - 500.000€',
            2 => '500.000 - 1M€',
            3 => '1 - 2 M€',
            4 => '2 - 4 M€',
            5 => '+ 4 M€',
        ],

        'ambito_rural' => [
            1 => 'sí',
            0 => 'no',
        ],

        'politicas_sostenibilidad' => [
            1 => 'sí',
            0 => 'no',
        ],

        'transformacion_digital' => [
            1 => 'sí',
            0 => 'no',
        ],

        'mujer_responsable' => [
            1 => 'sí',
            0 => 'no',
        ],

        'porcentaje_mujeres' => [
            1 => 'Inferior a 30%',
            2 => 'Entre 30% y 50%',
            3 => 'Superior al 50%',
        ],
    ],

];
