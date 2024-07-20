# CLICK Integration Laravel
This library allows you to integrate payment acceptance using `"CLICK"` payment system into `PHP` web applications.
For the library to function properly, the user must be connected to Click Merchant using the Shop API scheme.
Detailed documentation is available here __https://docs.click.uz__.

## Installation via Composer
```
composer require shoyim/click
```

#### Publish Configuration
```bash
php artisan vendor:publish --provider="Shoyim\Click\ClickServiceProvider" --tag="config"
# db migration
php artisan migrate
```


#### Click configuration
```dotenv
CLICK_ENDPOINT=https://api.click.uz/v2/merchant/
CLICK_MERCHANT_ID=your-merchant-id
CLICK_SERVICE_ID=your-service-id
CLICK_USER_ID=your-user-id
CLICK_SECRET_KEY=your-secret-key
```


List of the Payments methods
1) `on_invoice_creating` and `on_invoice_created` for create invoice
2) `on_invoice_checking` and `on_invoice_checked` for check invoice
3) `on_canceling` and `on_canceled` for cancel payment
4) `on_card_token_creating` and `on_card_token_created` for create card token
5) `on_card_token_verifying` and `on_card_token_verified` for verify card token
6) `on_card_token_paying` and `on_card_token_payed` for payment via card token
7) `on_card_token_deleting` and `on_card_token_deleted` for delete card token
8) `on_payment_checking` and `on_payment_checked` for check payment status by merchant_id
9) `on_checking_with_merchant_trans_id` and `on_checked_with_merchant_trans_id` for check payment status by merchant_trans_id

If you want check whether the payment user exists, complete this method

