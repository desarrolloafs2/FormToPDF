<?php

use App\Services\Formatters\EoiFormDataFormatterService;
use App\Services\Formatters\MecFormDataFormatterService;
use App\Services\Formatters\FormDataFormatterService;

return [
    'types' => [
        'sepe' => [
            'request' => \App\Http\Requests\StoreParticipantRequest::class,
            'formatter' => FormDataFormatterService::class,
        ],
        'eoi' => [
            'request' => \App\Http\Requests\EoiParticipantRequest::class,
             'formatter' =>EoiFormDataFormatterService::class,
        ],
        'mec' => [
            'request' => \App\Http\Requests\MecParticipantRequest::class,
            'formatter' => MecFormDataFormatterService::class, 
            
        ],
    ],
];
