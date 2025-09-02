<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Valores por defecto para testing
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'firstSurname' => 'Pérez',
        'secondSurname' => 'Gómez',
        'name' => 'Juan',
        'tipo_documento' => 'NIF',
        'nif' => '54078631L',
        'sexo' => 'M',
        'birthdate' => '1990-01-01',
        'ssnumber' => '',
        'tipo_via' => 'Calle',
        'address' => 'Calle Falsa 123',
        'locality' => 'Madrid',
        'postalCode' => '28001',
        'province' => 'Madrid',
        'ccaa' => 'Comunidad de Madrid',
        'phone' => '600123456',
        'phone2' => '828123456',
        'email' => 'juan@example.com',
    ],

    /*
    |--------------------------------------------------------------------------
    | Estructura de filas (rows) y campos para el formulario
    |--------------------------------------------------------------------------
    */
    'rows' => [

        // Row 1: Apellidos
        [
            'fields' => [
                ['name' => 'firstSurname', 'label' => 'Primer Apellido', 'type' => 'text', 'required' => true, 'col' => 6],
                ['name' => 'secondSurname', 'label' => 'Segundo Apellido', 'type' => 'text', 'required' => false, 'col' => 6],
            ],
        ],

        // Row 2: Nombre y documento
        [
            'fields' => [
                ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'required' => true, 'col' => 5],
                ['name' => 'tipo_documento', 'label' => 'Tipo de Documento', 'type' => 'select', 'options' => array_combine(config('options.dni'), config('options.dni')), 'required' => true, 'col' => 2],
                ['name' => 'nif', 'label' => 'Nº documento identidad', 'type' => 'text', 'required' => true, 'col' => 5],
            ],
        ],

        // Row 3: Género, fecha nacimiento, SSN
        [
            'fields' => [
                ['name' => 'sexo', 'label' => 'Género', 'type' => 'select', 'options' => array_combine(config('options.sexo'), config('options.sexo')), 'required' => true, 'col' => 3],
                ['name' => 'birthdate', 'label' => 'Fecha de Nacimiento', 'type' => 'date', 'required' => true, 'col' => 3, 'min' => now()->subYears(150)->toDateString(), 'max' => now()->subYears(16)->toDateString()],
                ['name' => 'ssnumber', 'label' => 'Nº de afiliación a la Seguridad Social', 'type' => 'text', 'required' => false, 'col' => 6],
            ],
        ],

        // Row 4: Tipo de vía y dirección
        [
            'fields' => [
                ['name' => 'tipo_via', 'label' => 'Tipo de Vía', 'type' => 'select', 'options' => array_combine(config('options.via'), config('options.via')), 'required' => true, 'col' => 2],
                ['name' => 'address', 'label' => 'Dirección', 'type' => 'text', 'required' => true, 'col' => 10],
            ],
        ],

        // Row 5: Localidad, Código Postal, Provincia y CCAA
        [
            'fields' => [
                ['name' => 'locality', 'label' => 'Localidad', 'type' => 'text', 'required' => true, 'col' => 4],
                ['name' => 'postalCode', 'label' => 'Código Postal', 'type' => 'number', 'required' => true, 'col' => 2, 'min' => 10000, 'max' => 52999],
                ['name' => 'province', 'label' => 'Provincia', 'type' => 'select', 'options' => array_combine(config('options.provincias'), config('options.provincias')), 'required' => true, 'col' => 3],
                ['name' => 'ccaa', 'label' => 'Comunidad Autónoma', 'type' => 'select', 'options' => array_combine(config('options.ccaa'), config('options.ccaa')), 'required' => true, 'col' => 3],
            ],
        ],

        // Row 6: Teléfonos y correo
        [
            'fields' => [
                ['name' => 'phone', 'label' => 'Teléfono Móvil', 'type' => 'tel', 'required' => true, 'col' => 3],
                ['name' => 'phone2', 'label' => 'Teléfono Fijo', 'type' => 'tel', 'required' => false, 'col' => 3],
                ['name' => 'email', 'label' => 'Correo Electrónico', 'type' => 'email', 'required' => true, 'col' => 6],
            ],
        ],

    ],

];
