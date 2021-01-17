<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],


    'facebook' => [
        'client_id' => '201751207713115', 
        'client_secret' => 'ed6c883ce38f2d6923c4131e45ea9700',
        'redirect' => 'https://tod-z.com/fb_callback',

    ], 
    'linkedin' => [
        'client_id' => '78t08nqgfoaqqn',
        'client_secret' => 'yAUthsrVJvxrXp8G',
        'redirect' => 'https://tod-z.com/li_callback',
    ],


   /*'facebook' => [
        'client_id' => '2861875133916880', 
        'client_secret' => '0d520f0161e028ccdf22c7a21f6f81ab',
        'redirect' => 'http://localhost:8000/fb_callback',

    ],

    'linkedin' => [
        'client_id' => '782b9amprv94o7',
        'client_secret' => 'q8pDAw7JvWcnIIE3',
        'redirect' => 'http://localhost:8000/li_callback',
    ],*/
     

];
