<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    /* Custom */
    'polleo' => [
        'user' => env('POLLEO_API_USER'),
        'pass' => env('POLLEO_API_PASS'),
        'header' => 'Basic ' . base64_encode(env('POLLEO_API_USER') . ':' . env('POLLEO_API_PASS')),
        'base_url' => 'https://dev.polleosport.hr',
    ],

    'loyalty' => [
        'base_url' => 'http://165.227.137.83:9000/api/v1/',
    ]

];
