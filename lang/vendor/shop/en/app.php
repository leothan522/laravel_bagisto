<?php

$copyrigth = '© '.config('app.name').' :current_year';

return [
    'customers' => [
        'forgot-password' => ['footer' => $copyrigth],
        'reset-password' => ['footer' => $copyrigth],
        'login-form' => ['footer' => $copyrigth],
        'signup-form' => ['footer' => $copyrigth],
    ],

    'checkout' => [
        'onepage' => [
            'summary' => [
                'transfer-data' => 'Transfer Details',
                'bank-origin' => 'Origin Bank',
                'select-bank' => 'Select a bank',
                'reference' => 'Reference Number',
                'amount-paid' => 'Amount Paid',
                'payment-required' => 'All payment fields are required to process your order.',
                'other-payment' => 'Other / Mobile Payment', // <-- Nueva clave
                'payment-info' => 'Payment Information',
                'account-holder' => 'Account Holder',
                'account-number' => 'Account Number',
                'id-number' => 'Tax ID / RIF',
                'phone' => 'Phone Number',
                'amount-to-pay' => 'Amount to Transfer (Bs)',
                'copied' => 'Copied!',
                'exchange-rate' => 'Exchange rate: 1 USD = :rate VES',
            ],
        ],
    ],
];
