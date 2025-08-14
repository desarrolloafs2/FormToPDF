<?php

use App\Services\Formatters\EoiFormDataFormatterService;
use App\Services\Formatters\MecFormDataFormatterService;

return [
    'types' => [
        'sepe' => [
            'request' => \App\Http\Requests\StoreParticipantRequest::class,
            'formatter' => \App\Services\Formatters\FormDataFormatterService::class,
        ],
        'eoi' => [
            'request' => \App\Http\Requests\EoiParticipantRequest::class,
             'formatter' => \App\Services\Formatters\EoiFormDataFormatterService::class,
        ],
        'mec' => [
            'request' => \App\Http\Requests\MecParticipantRequest::class,
            'formatter' =>EoiFormDataFormatterService::class, // Use EoiFormDataFormatterService for MEC as well
            
        ],
    ],
];
