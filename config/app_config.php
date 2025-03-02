<?php

    return [
        'stripe' => [
            'key' => env('STRIPE_KEY'),
            'secret' => env('STRIPE_SECRET'),
            'webhook_key' => env('STRIPE_WEBHOOK_KEY'),
        ],
        'app_url' => env('APP_URL'),
    ];
