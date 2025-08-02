<?php

return [
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
    'webhook' => [
        'secret' => env('STRIPE_WEBHOOK_SECRET'),
        'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
    ],
    'model' => App\Models\User::class,
    'currency' => env('CASHIER_CURRENCY', 'mxn'),
    'currency_locale' => env('CASHIER_CURRENCY_LOCALE', 'mx'),
];
