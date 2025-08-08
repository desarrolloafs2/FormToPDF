<?php

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
    ],
];
