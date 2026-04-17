<?php

// © Derechos de autor 2010 - :current_year, Webkul Software (Registrado en India). Todos los derechos reservados.
$copyrigth = '© '.config('app.name').' :current_year';

return [
    'customers' => [
        'forgot-password' => [
            'footer' => $copyrigth,
        ],

        'reset-password' => [
            'footer' => $copyrigth,
        ],

        'login-form' => [
            'footer' => $copyrigth,
        ],

        'signup-form' => [
            'footer' => $copyrigth,
        ],
    ],
    // --- NUEVAS TRADUCCIONES PARA TIENDA_EDELYS ---
    'checkout' => [
        'onepage' => [
            'summary' => [
                'transfer-data' => 'Datos de la Transferencia',
                'bank-origin' => 'Banco de Origen',
                'select-bank' => 'Seleccione un banco',
                'reference' => 'Referencia',
                'amount-paid' => 'Monto Pagado',
                'payment-required' => 'Todos los campos de pago son obligatorios para procesar su orden.',
                'other-payment' => 'Otro / Pago Móvil', // <-- Nueva clave
                'payment-info' => 'Información de Pago',
                'account-holder' => 'Titular',
                'account-number' => 'N° Cuenta',
                'id-number' => 'Cédula/RIF',
                'phone' => 'Teléfono',
                'amount-to-pay' => 'Monto a Transferir (Bs)',
                'copied' => '¡Copiado!',
                'exchange-rate' => 'Tasa aplicada: 1 USD = :rate VES',
            ],
        ],
    ],
];
