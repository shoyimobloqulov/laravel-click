<?php

use GuzzleHttp\Client;

use Illuminate\Support\Facades\Request;
use Shoyim\Click\Models\ClickData;
use Shoyim\Click\Models\ClickTransaction;
use Shoyim\Click\Exceptions\ClickException;
class ClickService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('click.endpoint_url'),
        ]);
    }

    public function handleRequest(Request $request)
    {
        $data = new ClickData($request);

        // Konfiguratsiya
        $config = [
            'secret_key' => config('click.secret_key'),
        ];

        // Ma'lumotni tekshirish
        $data->validate($config);

        // Harakatni tekshirish
        if ($data->action == 0) {
            return $this->prepare($data);
        } elseif ($data->action == 1) {
            return $this->complete($data);
        } else {
            throw new ClickException('Action not found', ClickException::ERROR_ORDER_NOT_FOUND);
        }
    }

    private function prepare(ClickData $data)
    {
        $response = $this->client->post('/prepare', [
            'json' => [
                'click_trans_id' => $data->click_trans_id,
                'service_id' => $data->service_id,
                'amount' => $data->amount,
                'merchant_trans_id' => $data->merchant_trans_id,
                'sign_string' => $data->sign_string,
            ],
        ]);

        $responseBody = json_decode($response->getBody()->getContents(), true);

        // To'lov ma'lumotlarini saqlash
        ClickTransaction::create([
            'click_trans_id' => $data->click_trans_id,
            'service_id' => $data->service_id,
            'click_paydoc_id' => $data->click_paydoc_id,
            'merchant_trans_id' => $data->merchant_trans_id,
            'amount' => $data->amount,
            'action' => $data->action,
            'error' => $data->error,
            'error_note' => $data->error_note,
            'sign_time' => $data->sign_time,
            'sign_string' => $data->sign_string,
            'status' => 'pending',
        ]);

        return $responseBody;
    }

    private function complete(ClickData $data)
    {
        $response = $this->client->post('/complete', [
            'json' => [
                'click_trans_id' => $data->click_trans_id,
                'merchant_trans_id' => $data->merchant_trans_id,
                'sign_string' => $data->sign_string,
            ],
        ]);

        $responseBody = json_decode($response->getBody()->getContents(), true);

        // To'lov holatini yangilash
        $transaction = ClickTransaction::where('merchant_trans_id', $data->merchant_trans_id)->first();

        if (!$transaction) {
            throw new ClickException('Order not found', ClickException::ERROR_ORDER_NOT_FOUND);
        }

        if ($transaction->amount != $data->amount) {
            throw new ClickException('Invalid amount', ClickException::ERROR_INVALID_AMOUNT);
        }

        if ($transaction->status == 'completed') {
            throw new ClickException('Already paid', ClickException::ERROR_ALREADY_PAID);
        }

        $transaction->update(['status' => 'completed']);

        return $responseBody;
    }
}