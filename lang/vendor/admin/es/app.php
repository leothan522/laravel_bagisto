<?php
// 'Desarrollado por :bagisto, un proyecto de código abierto de :webkul.',
$footer = 'Desarrollado por <a href="https://t.me/Leothan" target="_blank" class="text-blue-600 hover:underline">Ing. Yonathan Castillo</a>, usando <a href="https://bagisto.com/en/" target="_blank" class="text-blue-600 hover:underline">Bagisto</a>';

return [
    'users' => [
        'sessions' => [
            'powered-by-description' => $footer,
        ],

        'forget-password' => [
            'create' => [
                'powered-by-description' => $footer,
            ],
        ],

        'reset-password' => [
            'powered-by-description' => $footer,
        ],
    ],

    'components' => [
        'layouts' => [
            'powered-by' => [
                'description' => $footer,
            ],
        ],
    ],

    'footer' => [
        'copy-right' => $footer,
    ],
];
