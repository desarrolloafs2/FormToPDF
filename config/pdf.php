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
            ],
        ],
        'eoi' => [
            'layout' => 'pdf/layouts/eoi.pdf',
            'upload_path' => 'MATRICULAS WEB/EOI',
            'signature_coords' => [
                'x' => 50,    
                'y' => 200,   
                'width' => 150,
            ],
        ],
        'mec' => [
            'layout' => 'pdf/layouts/mec.pdf',
            'upload_path' => 'MATRICULAS WEB/MEC',
            'signature_coords' => [
                'x' => 70,
                'y' => 250,
                'width' => 90,
            ],
        ],
    ],
    'generated_path' => 'pdf/generated/',
    'signed_path' => 'pdf/signed/',
    'image_path' => 'image/',
];
