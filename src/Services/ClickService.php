<?php
namespace Shoyim\Click\Services;

use Illuminate\Support\Facades\Log;
use Shoyim\Click\Models\ClickTransaction;

class ClickService
{
    protected $service;

    public function __construct(ClickService $service)
    {
        $this->service = $service;
    }

    public function prepare($data): array
    {
        // Проверка сигнатуры
        $expectedSignString = md5(
            $data['click_trans_id'] .
            $data['service_id'] .
            $this->service->secret_key .
            $data['merchant_trans_id'] .
            $data['amount'] .
            $data['action'] .
            $data['sign_time']
        );

        if ($data['sign_string'] !== $expectedSignString) {
            return [
                'error' => -1,
                'error_note' => 'SIGN CHECK FAILED!',
            ];
        }

        // Логика проверки и сохранения транзакции
        $transaction = ClickTransaction::updateOrCreate(
            ['click_trans_id' => $data['click_trans_id']],
            $data
        );

        // Возвращаем успешный ответ
        return [
            'click_trans_id' => $data['click_trans_id'],
            'merchant_trans_id' => $data['merchant_trans_id'],
            'merchant_prepare_id' => $transaction->id,
            'error' => 0,
            'error_note' => 'Success',
        ];
    }

    public function complete($data)
    {
        // Проверка сигнатуры
        $expectedSignString = md5(
            $data['click_trans_id'] .
            $data['service_id'] .
            $this->service->secret_key .
            $data['merchant_trans_id'] .
            $data['merchant_prepare_id'] .
            $data['amount'] .
            $data['action'] .
            $data['sign_time']
        );

        if ($data['sign_string'] !== $expectedSignString) {
            return [
                'error' => -1,
                'error_note' => 'SIGN CHECK FAILED!',
            ];
        }

        // Логика завершения транзакции
        $transaction = ClickTransaction::where('click_trans_id', $data['click_trans_id'])->first();
        if (!$transaction) {
            return [
                'error' => -6,
                'error_note' => 'Transaction does not exist',
            ];
        }

        // Обновляем статус транзакции
        $transaction->update([
            'merchant_confirm_id' => $data['merchant_confirm_id'],
            'error' => $data['error'],
            'error_note' => $data['error_note'],
        ]);

        // Возвращаем успешный ответ
        return [
            'click_trans_id' => $data['click_trans_id'],
            'merchant_trans_id' => $data['merchant_trans_id'],
            'merchant_confirm_id' => $data['merchant_confirm_id'],
            'error' => $data['error'],
            'error_note' => $data['error_note'],
        ];
    }
}