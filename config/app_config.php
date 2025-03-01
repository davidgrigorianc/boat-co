<?php

    return [
        'stripe' => [
            'key' => env('STRIPE_KEY'),
            'secret' => env('STRIPE_SECRET'),
        ],
        'app_url' => env('APP_URL'),
    ];
