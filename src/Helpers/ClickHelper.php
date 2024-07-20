<?php

namespace Shoyim\Click\Helpers;

class ClickHelper
{
    public $endpoint;
    private $script_name;
    private $request_url;
    public $method;
    public $timestamp;
    public $url;
    public function __construct()
    {
        $this->endpoint = config('click.endpoint', 'https://api.click.uz/v2/merchant/');
        $this->script_name = $_SERVER['SCRIPT_NAME'];
        $this->request_url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->timestamp = $_SERVER['REQUEST_TIME'];
        $this->url = $this->_url();
    }

    private function _url()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function check_card_number($card_number)
    {
        if (preg_match('/[0-9]{12}/', $card_number)) {
            return $card_number;
        }
        if (preg_match('/[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}/', $card_number)) {
            $card_number = explode('-', $card_number);
            $card_number = implode('', $card_number);
            return $card_number;
        }
        return null;
    }

    public function check_phone_number($phone_number): ?string
    {
        if (strlen($phone_number) != 0 && $phone_number[0] == '+') {
            $phone_number = substr($phone_number, 1, strlen($phone_number));
            if (preg_match('/[0-9]{12}/', $phone_number)) {
                return $phone_number;
            }
            return null;
        }
        if (preg_match('/[0-9]{12}/', $phone_number)) {
            return $phone_number;
        }
        if (preg_match('/[0-9]{9}/', $phone_number)) {
            return '998' . $phone_number;
        }
        if (preg_match('/[0-9]{8}/', $phone_number)) {
            return '9989' . $phone_number;
        }
        return null;
    }
}
