[![Total Downloads](https://poser.pugx.org/shoyim/click/d/total.svg)](https://packagist.org/packages/shoyim/click)
[![Latest Stable Version](https://poser.pugx.org/shoyim/click/v/stable.svg)](https://packagist.org/packages/shoyim/click)
[![Latest Unstable Version](https://poser.pugx.org/shoyim/click/v/unstable.svg)](https://packagist.org/packages/shoyim/click)
[![License](https://poser.pugx.org/shoyim/click/license.svg)](https://packagist.org/packages/shoyim/click)

> [!TIP]
> This library allows you to integrate payment acceptance using `"CLICK"` payment system into `Laravel` web applications.
> For the library to function properly, the user must be connected to Click Merchant using the Shop API scheme.
> Detailed documentation is available here __https://docs.click.uz__.

## Installation via Composer
```
composer require shoyim/click dev-main
```

#### Publish Configuration
```bash
php artisan vendor:publish --provider="Shoyim\Click\Providers\ClickServiceProvider" --tag="config"
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
- [ ] `on_invoice_creating` and `on_invoice_created` for create invoice
- [ ] `on_invoice_checking` and `on_invoice_checked` for check invoice
- [ ] `on_canceling` and `on_canceled` for cancel payment
- [ ] `on_card_token_creating` and `on_card_token_created` for create card token
- [ ] `on_card_token_verifying` and `on_card_token_verified` for verify card token
- [ ] `on_card_token_paying` and `on_card_token_payed` for payment via card token
- [ ] `on_card_token_deleting` and `on_card_token_deleted` for delete card token
- [ ] `on_payment_checking` and `on_payment_checked` for check payment status by merchant_id
- [ ] `on_checking_with_merchant_trans_id` and `on_checked_with_merchant_trans_id` for check payment status by merchant_trans_id

If you want check whether the payment user exists, complete this method

