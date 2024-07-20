<?php

return [
    'endpoint' => env('CLICK_ENDPOINT', 'https://api.click.uz/v2/merchant/'),
    'click' => [
        'merchant_id'   => env('CLICK_MERCHANT_ID', 1111),
        'service_id'    => env('CLICK_SERVICE_ID', 2222),
        'user_id'       => env('CLICK_USER_ID', 3333),
        'secret_key'    => env('CLICK_SECRET_KEY', 'AAAAAAAA')
    ]
];
