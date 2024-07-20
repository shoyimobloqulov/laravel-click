<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Click API Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for interacting with Click API.
    |
    */

    'prepare_url' => env('CLICK_PREPARE_URL', 'http://example.com/prepare'),
    'complete_url' => env('CLICK_COMPLETE_URL', 'http://example.com/complete'),
    'service_id' => env('CLICK_SERVICE_ID', 0),
    'merchant_user_id' => env('CLICK_MERCHANT_USER_ID', 0),
    'secret_key' => env('CLICK_SECRET_KEY', 'your-secret-key'),
    'merchant_trans_id' => env('CLICK_MERCHANT_TRANS_ID', 'default-transaction-id'),
];