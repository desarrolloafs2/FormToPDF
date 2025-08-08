<?php
return [
    'types' => [
        'sepe' => [
            'layout' => 'pdf/layouts/annex1.pdf',
            'upload_path' => 'MATRICULAS WEB/SEPE',
            'signature_coords' => [
                'x' => 70,
                'y' => 150,
                'width' => 90,
                'page' => 3
            ],
        ],
        'eoi' => [
            'layout' => 'pdf/layouts/eoi.pdf',
            'upload_path' => 'MATRICULAS WEB/EOI',
            'signature_coords' => [
                'x' => 70,
                'y' => 275,
                'width' => 90,
                'page' => 3
            ],
        ],
        'mec' => [
            'layout' => 'pdf/layouts/mec.pdf',
            'upload_path' => 'MATRICULAS WEB/MEC',
        ],
    ],
    'generated_path' => 'pdf/generated/',
    'signed_path' => 'pdf/signed/',
    'image_path' => 'image/',
];

