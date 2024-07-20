<?php

namespace Shoyim\Click\Models;

use Click\Exceptions\ClickException;
use Illuminate\Http\Request;
use Shoyim\Click\Exceptions;

class ClickData
{
    public $click_trans_id;
    public $service_id;
    public $click_paydoc_id;
    public $merchant_trans_id;
    public $amount;
    public $action;
    public $error;
    public $error_note;
    public $sign_time;
    public $sign_string;

    public function __construct(Request $request)
    {
        $this->click_trans_id = $request->input('click_trans_id');
        $this->service_id = $request->input('service_id');
        $this->click_paydoc_id = $request->input('click_paydoc_id');
        $this->merchant_trans_id = $request->input('merchant_trans_id');
        $this->amount = $request->input('amount');
        $this->action = $request->input('action');
        $this->error = $request->input('error');
        $this->error_note = $request->input('error_note');
        $this->sign_time = $request->input('sign_time');
        $this->sign_string = $request->input('sign_string');
    }

    public function validate($config)
    {
        $sign_string = md5(
            $this->click_trans_id .
            $this->service_id .
            $config['secret_key'] .
            $this->merchant_trans_id .
            ($this->action == 1 ? $this->amount : '') .
            $this->sign_time
        );

        if ($sign_string !== $this->sign_string) {
            throw new ClickException('SIGN CHECK FAILED', ClickException::ERROR_SIGN_CHECK_FAILED);
        }
    }
}
