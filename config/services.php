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
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],
    
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    
    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    
    /* Custom */
    'polleo' => [
        'user'     => env('POLLEO_API_USER'),
        'pass'     => env('POLLEO_API_PASS'),
        'header'   => 'Basic ' . base64_encode(env('POLLEO_API_USER') . ':' . env('POLLEO_API_PASS')),
        'base_url' => 'https://dev.polleosport.hr',
    ],
    
    'loyalty' => [
        'base_url' => 'http://165.227.137.83:9000/api/v1/',
    ],
    
    'sms_service' => [
        'user'         => env('SMS_SERVICE_USER'),
        'pass'         => env('SMS_SERVICE_PASS'),
        'api_key'      => env('SMS_SERVICE_API_KEY'),
        'app_id'       => env('SMS_SERVICE_APP_ID'),
        'msg_id'       => env('SMS_SERVICE_MESSAGE_ID'),
        'basic_header' => 'Basic ' . base64_encode(env('SMS_SERVICE_USER') . ':' . env('SMS_SERVICE_PASS')),
        'app_header'   => 'App ' . config('services.sms_service.api_key'),
        'base_url' => 'https://vrxgm.api.infobip.com/2fa/1/',
    ]

];
