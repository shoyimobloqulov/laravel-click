<?php

namespace Shoyim\Click\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;

class ClickMerchantServices
{
    protected Client $client;
    protected mixed $merchantId;
    protected mixed $serviceId;
    protected mixed $merchantUserId;
    protected mixed $secretKey;

    /**
     * Constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->merchantId = Config::get('click.click.merchant_id');
        $this->serviceId = Config::get('click.click.service_id');
        $this->merchantUserId = Config::get('click.click.merchant_user_id');
        $this->secretKey = Config::get('click.click.secret_key');
    }

    /**
     * Generate Auth Header.
     *
     * @param string $timestamp
     * @return string
     */
    protected function generateAuthHeader($timestamp): string
    {
        $digest = sha1($timestamp . $this->secretKey);
        return "{$this->merchantUserId}:{$digest}:{$timestamp}";
    }

    /**
     * Make a request to Click API.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $data
     * @return ResponseInterface
     * @throws Exception|GuzzleException
     */
    protected function makeRequest(string $method, string $endpoint, array $data = []): ResponseInterface
    {
        $timestamp = time();
        $authHeader = $this->generateAuthHeader($timestamp);

        try {
            return $this->client->request($method, $endpoint, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Auth' => $authHeader
                ],
                'json' => $data
            ]);
        } catch (Exception $e) {
            Log::error('Click API Request Failed', [
                'method' => $method,
                'endpoint' => $endpoint,
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Create an invoice.
     *
     * @param float $amount
     * @param string $phoneNumber
     * @param string $merchantTransId
     * @return array
     * @throws Exception|GuzzleException
     */
    public function createInvoice(float $amount, string $phoneNumber, string $merchantTransId): array
    {
        $endpoint = 'https://api.click.uz/v2/merchant/invoice/create';
        $data = [
            'service_id' => $this->serviceId,
            'amount' => $amount,
            'phone_number' => $phoneNumber,
            'merchant_trans_id' => $merchantTransId
        ];

        $response = $this->makeRequest('POST', $endpoint, $data);
        return json_decode($response->getBody(), true);
    }

    /**
     * Check invoice status.
     *
     * @param int $invoiceId
     * @return array
     * @throws Exception|GuzzleException
     */
    public function checkInvoiceStatus($invoiceId): array
    {
        $endpoint = "https://api.click.uz/v2/merchant/invoice/status/{$this->serviceId}/{$invoiceId}";
        $response = $this->makeRequest('GET', $endpoint);
        return json_decode($response->getBody(), true);
    }

    /**
     * Check payment status.
     *
     * @param int $paymentId
     * @return array
     * @throws Exception|GuzzleException
     */
    public function checkPaymentStatus($paymentId): array
    {
        $endpoint = "https://api.click.uz/v2/merchant/payment/status/{$this->serviceId}/{$paymentId}";
        $response = $this->makeRequest('GET', $endpoint);
        return json_decode($response->getBody(), true);
    }

    /**
     * Check payment status by merchant transaction ID.
     *
     * @param string $merchantTransId
     * @return array
     * @throws Exception|GuzzleException
     */
    public function checkPaymentStatusByMerchantTransId($merchantTransId): array
    {
        $endpoint = "https://api.click.uz/v2/merchant/payment/status_by_mti/{$this->serviceId}/{$merchantTransId}";
        $response = $this->makeRequest('GET', $endpoint);
        return json_decode($response->getBody(), true);
    }

    /**
     * Cancel a payment.
     *
     * @param int $paymentId
     * @return array
     * @throws Exception|GuzzleException
     */
    public function cancelPayment($paymentId): array
    {
        $endpoint = "https://api.click.uz/v2/merchant/payment/reversal/{$this->serviceId}/{$paymentId}";
        $response = $this->makeRequest('DELETE', $endpoint);
        return json_decode($response->getBody(), true);
    }

    /**
     * Create a card token.
     *
     * @param string $cardNumber
     * @param string $expireDate
     * @param bool $temporary
     * @return array
     * @throws Exception|GuzzleException
     */
    public function createCardToken($cardNumber, $expireDate, $temporary = false): array
    {
        $endpoint = 'https://api.click.uz/v2/merchant/card_token/request';
        $data = [
            'service_id' => $this->serviceId,
            'card_number' => $cardNumber,
            'expire_date' => $expireDate,
            'temporary' => $temporary ? 1 : 0
        ];

        $response = $this->makeRequest('POST', $endpoint, $data);
        return json_decode($response->getBody(), true);
    }

    /**
     * Verify a card token.
     *
     * @param string $cardToken
     * @param int $smsCode
     * @return array
     * @throws Exception|GuzzleException
     */
    public function verifyCardToken($cardToken, $smsCode): array
    {
        $endpoint = 'https://api.click.uz/v2/merchant/card_token/verify';
        $data = [
            'service_id' => $this->serviceId,
            'card_token' => $cardToken,
            'sms_code' => $smsCode
        ];

        $response = $this->makeRequest('POST', $endpoint, $data);
        return json_decode($response->getBody(), true);
    }

    /**
     * Make a payment with a card token.
     *
     * @param string $cardToken
     * @param float $amount
     * @param string $merchantTransId
     * @return array
     * @throws Exception|GuzzleException
     */
    public function payWithCardToken(string $cardToken, float $amount, string $merchantTransId): array
    {
        $endpoint = 'https://api.click.uz/v2/merchant/card_token/payment';
        $data = [
            'service_id' => $this->serviceId,
            'card_token' => $cardToken,
            'amount' => $amount,
            'transaction_parameter' => $merchantTransId
        ];

        $response = $this->makeRequest('POST', $endpoint, $data);
        return json_decode($response->getBody(), true);
    }

    /**
     * Delete a card token.
     *
     * @param string $cardToken
     * @return array
     * @throws Exception|GuzzleException
     */
    public function deleteCardToken($cardToken): array
    {
        $endpoint = "https://api.click.uz/v2/merchant/card_token/{$this->serviceId}/{$cardToken}";
        $response = $this->makeRequest('DELETE', $endpoint);
        return json_decode($response->getBody(), true);
    }
}
