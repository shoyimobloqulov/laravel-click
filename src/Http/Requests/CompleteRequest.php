<?php

namespace Shoyim\Click\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'click_trans_id' => 'required|numeric',
            'service_id' => 'required|numeric',
            'merchant_trans_id' => 'required|string',
            'amount' => 'required|numeric',
            'action' => 'required|in:0,1',
            'error' => 'required|in:0,1,2,3,4,5,6,7,8,9,10,11,12',
            'error_note' => 'required|string',
            'sign_time' => 'required',
            'sign_string' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'click_trans_id.required' => 'Click transaction ID is required.',
            'service_id.required' => 'Service ID is required.',
            'merchant_trans_id.required' => 'Merchant transaction ID is required.',
            'amount.required' => 'Amount is required.',
            'action.required' => 'Action is required.',
            'error.required' => 'Error is required.',
            'error_note.required' => 'Error note is required.',
            'sign_time.required' => 'Sign time is required.',
            'sign_string.required' => 'Sign string is required.',
        ];
    }
}
