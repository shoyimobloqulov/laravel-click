<?php

namespace Shoyim\Click\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Shoyim\Click\Exceptions\ClickException;
use Shoyim\Click\Models\ClickTransaction;
use Shoyim\Click\Models\Transaction;

class ClickServices
{
    /**
     * @throws ClickException
     */
    public function prepare(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'click_trans_id' => 'required|numeric|unique:click_transactions,click_trans_id',
            'service_id' => 'required|numeric',
            'merchant_trans_id' => 'required|string',
            'amount' => 'required|numeric',
            'action' => 'required|in:0,1',
            'error' => 'required|in:0,1,2,3,4,5,6,7,8,9,10,11,12',
            'error_note' => 'required|string',
            'sign_time' => 'required',
            'sign_string' => 'required|string',
        ]);

        if ($validation->fails()) {
            throw new ClickException(ClickTransaction::ERROR_IN_REQUEST_CLICK);
        }

//        if($request->input('action') !== ClickTransaction::ACTION_PREPARE) {
//            return $this->errorResponse(ClickTransaction::ACTION_NOT_FOUND);
//        }

        $click_trans_id = $request->input('click_trans_id');
        $merchant_trans_id = $request->input('merchant_trans_id');
        $service_id = $request->input('service_id');
        $click_paydoc_id = $request->input('click_paydoc_id');
        $amount = $request->input('amount');
        $sign_time = $request->input('sign_time');
        $situation = $request->input('error');
        $user = User::where('id', $merchant_trans_id)->first();
        if(!$user){
            throw new ClickException(ClickTransaction::USER_DOES_NOT_EXISTS);
        }

        if($situation == ClickTransaction::SUCCESS){
            $transaction = ClickTransaction::create([
                'click_trans_id' => $click_trans_id,
                'service_id' => $service_id,
                'click_paydoc_id' => $click_paydoc_id,
                'merchant_trans_id' => $merchant_trans_id,
                'amount' => $amount * 100,
                'sign_time' => $sign_time,
                'situation' => $situation,
                'status' => ClickTransaction::ACTION_PREPARE,
            ]);
            return $this->success($transaction);
        }else{
            throw new ClickException($situation);
        }
    }

    /**
     * @throws ClickException
     */
    public function complete(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'click_trans_id' => 'required|numeric',
            'service_id' => 'required|numeric',
            'merchant_trans_id' => 'required|string',
            'amount' => 'required|numeric',
            'action' => 'required|in:0,1',
            'error' => 'required|in:0,1,2,3,4,5,6,7,8,9,10,11,12',
            'error_note' => 'required|string',
            'sign_time' => 'required',
            'sign_string' => 'required|string',
        ]);

        if ($validation->fails()) {
            throw new ClickException(ClickTransaction::ERROR_IN_REQUEST_CLICK);
        }

//        if($request->input('action') !== ClickTransaction::ACTION_COMPLETE) {
//            return $this->errorResponse(ClickTransaction::ACTION_NOT_FOUND);
//        }
        $merchant_trans_id = $request->input('merchant_trans_id');
        $user = User::where('id', $merchant_trans_id)->first();
        if(!$user){
            throw new ClickException(ClickTransaction::USER_DOES_NOT_EXISTS);
        }

        $click_trans_id = $request->input('click_trans_id');
        $transaction = ClickTransaction::where('click_trans_id', $click_trans_id)->first();
        if(!$transaction){
            throw new ClickException(ClickTransaction::TRANSACTION_DOES_NOT_EXISTS);
        }

        if($transaction->status == ClickTransaction::ACTION_COMPLETE){
            throw new ClickException(ClickTransaction::ALREADY_PAID);
        }

        $situation = $request->input('error');

        if($situation == ClickTransaction::SUCCESS){
            $transaction->update([
                'status' => ClickTransaction::ACTION_COMPLETE,
            ]);
            $user->balance = $user->balance + $transaction->amount;
            $user->save();
            Transaction::create([
                'user_id' => $user->id,
                'amount' => $transaction->amount,
                'payment_system' => Transaction::PAYMENT_SYSTEM_CLICK,
                'payment_id' => $transaction->id,
            ]);
            return $this->success($transaction);
        }else{
            throw new ClickException($situation);
        }
    }

    protected function success(ClickTransaction $model, $error = 0): JsonResponse
    {
        return response()->json([
            'click_trans_id' => $model->click_trans_id,
            'merchant_trans_id' => $model->merchant_trans_id,
            'merchant_prepare_id' => $model->id,
            'error' => $error,
            'error_note' => "Success",
        ]);
    }
}
