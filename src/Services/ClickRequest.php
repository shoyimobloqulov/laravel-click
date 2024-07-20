<?php

namespace Shoyim\Click\Services;

use Illuminate\Http\Request;
use Shoyim\Click\Helpers\ClickHelper;
use Shoyim\Click\Exceptions\ClickException;

class ClickRequest
{
    public function __construct(ClickRequest $request, ClickHelper $helper)
    {
        $this->helper = $helper;

        $this->request = $request->all();

        if (count($this->request) == 0) {
            $request_body = $request->getContent();

            $this->request = json_decode($request_body, true);

            if (!$this->request) {
                throw new ClickException(
                    'Incorrect JSON-RPC object',
                    ClickException::ERROR_INVALID_JSON_RPC_OBJECT
                );
            }
        }
    }
    public function payment($provider)
    {
        if (isset($this->request['action']) && $this->request['action'] != null) {
            if ((int)$this->request['action'] == 0) {
                $this->request['type'] = 'prepare';
            }
            else {
                $this->request['type'] = 'complete';
            }
            return $this->request;
        }
        elseif (isset($this->request['phone_number']) && $this->request['phone_number'] != null) {
            // get phone number from request data
            $phone_number = $this->helper->check_phone_number($this->request['phone_number']);
            if ($phone_number != null) {
                if (isset($this->request['token']) && $this->request['token'] != null) {
                    // get token from request
                    $token = (int) $this->request['token'];
                    return [
                        'type' => 'phone_number',
                        'token' => $token,
                        'phone_number' => $phone_number
                    ];
                }
                // return exception
                throw new ClickException(
                    'Could not make a payment without payment_id or token',
                    ClickException::ERROR_COULD_NOT_PERFORM
                );
            }
            // return exception
            throw new ClickException(
                'Incorrect phone number',
                ClickException::ERROR_COULD_NOT_PERFORM
            );
        }
        // check type to create card token
        elseif (isset($this->request['card_number']) && $this->request['card_number'] != null) {
            // get card number
            $card_number = $this->helper->check_card_number($this->request['card_number']);
            if ($card_number != null) {
                if (isset($this->request['token']) && $this->request['token'] != null) {
                    // get token
                    $token = (int) $this->request['token'];
                    // get temporary
                    $temporary = 1;
                    if (isset($this->request['temporary'])) {
                        $temporary = $this->request['temporary'];
                    }
                    // return response array-like
                    return [
                        'type' => 'card_number',
                        'token' => $token,
                        'card_number' => $card_number,
                        'expire_date' => $this->request['expire_date'],
                        'temporary' => $temporary
                    ];
                }
                // return exception
                throw new ClickException(
                    'Could not make a payment without token',
                    ClickException::ERROR_COULD_NOT_PERFORM
                );
            }
            // return exception
            throw new ClickException(
                'Incorrect card number',
                ClickException::ERROR_COULD_NOT_PERFORM
            );
        }
        // check method type to verify card token
        elseif (isset($this->request['sms_code']) && $this->request['sms_code'] != null) {
            $sms_code = (string) $this->request['sms_code'];
            if (isset($this->request['token']) && $this->request['token'] != null) {
                // get token from request data
                $token = (int) $this->request['token'];
                // return response array-like
                return [
                    'type' => 'sms_code',
                    'token' => $token,
                    'sms_code' => $sms_code
                ];
            }
            // return response array-like
            throw new ClickException(
                'Could not make a payment without payment_id or token',
                ClickException::ERROR_COULD_NOT_PERFORM
            );
        }
        // check method type to payment via card token
        elseif (isset($this->request['card_token']) && $this->request['card_token'] != null) {
            // get card token
            $card_token = $this->request['card_token'];
            if (isset($this->request['token']) && $this->request['token'] != null) {
                // get token from request data
                $token = (int) $this->request['token'];
                // return response
                return [
                    'type' => 'card_token',
                    'token' => $token,
                    'card_token' => $card_token
                ];
            }
            // return exception
            throw new ClickException(
                'Could not make a payment without payment_id or token',
                ClickException::ERROR_COULD_NOT_PERFORM
            );
        }
        // check method type to delete card token
        elseif (isset($this->request['delete_card_token']) && $this->request['delete_card_token'] != null) {
            // get card token
            $card_token = $this->request['delete_card_token'];
            if (isset($this->request['token']) && $this->request['token'] != null) {
                // get token
                $token = (int) $this->request['token'];
                // return response as array-like
                return [
                    'type' => 'delete_card_token',
                    'token' => $token,
                    'card_token' => $card_token
                ];
            }
            // return exception
            throw new ClickException(
                'Could not make a payment without payment_id or token',
                ClickException::ERROR_COULD_NOT_PERFORM
            );
        }
        // check method type to check invoice id
        elseif (isset($this->request['check_invoice_id']) && $this->request['check_invoice_id'] != null) {
            // get invoice id from request data
            $invoice_id = $this->request['check_invoice_id'];
            if (isset($this->request['token']) && $this->request['token'] != null) {
                // get token id from request data
                $token = (int) $this->request['token'];
                // return response array-like
                return [
                    'type' => 'check_invoice_id',
                    'token' => $token,
                    'invoice_id' => $invoice_id
                ];
            }
            // return exception
            throw new ClickException(
                'Could not make a payment without payment_id or token',
                ClickException::ERROR_COULD_NOT_PERFORM
            );
        }
        // check method type to check payment status
        elseif (isset($this->request['payment_id']) && $this->request['payment_id'] != null) {
            // return response array-like
            return [
                'type' => 'check_payment',
                'payment_id' => (int)$this->request['payment_id']
            ];
        }
        // check method type to check payment status via merchant trans id
        elseif (isset($this->request['merchant_trans_id']) && $this->request['merchant_trans_id'] != null) {
            // get merchant trans id from request data
            $merchant_trans_id = (int)$this->request['merchant_trans_id'];
            if (isset($this->request['token']) && $this->request['token'] != null) {
                // token from request
                $token = (int)$this->request['token'];
                // return response
                return [
                    'type' => 'merchant_trans_id',
                    'token' => $token,
                    'merchant_trans_id' => $merchant_trans_id
                ];
            }
            // return en exception
            throw new ClickException(
                'Could not make a payment without payment_id or token',
                ClickException::ERROR_COULD_NOT_PERFORM
            );
        }
        // check method type to payment cancel
        elseif (isset($this->request['cancel_payment_id']) && $this->request['cancel_payment_id'] != null) {
            // return response array-like
            return [
                'type' => 'cancel',
                'payment_id' => $this->request['cancel_payment_id']
            ];
        }
    }

    /**
     * @name post method
     */
    public function post()
    {
        // return the request data array-like
        return $this->request;
    }
}
