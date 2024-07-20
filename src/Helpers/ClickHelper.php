<?php

namespace Shoyim\Click\Helpers;

use Shoyim\Click\Helpers\Configs;

/**
 * Helper class, this has included some basic methods.
 *
 * @example
 *      $helper = new Helper();
 *      $helper->checkPhoneNumber('998901112233');
 */
class ClickHelper
{
    /** @var string */
    public $endpoint = 'https://api.click.uz/v2/merchant/';
    /** @var string */
    private $scriptName;
    /** @var string */
    private $requestUrl;
    /** @var string */
    public $method;
    /** @var int */
    public $timestamp;
    /** @var string */
    public $url;
    /** @var Configs */
    private $configs;

    /**
     * Helper constructor
     */
    public function __construct()
    {
        // set configs
        $this->configs = new Configs();
        $providerConfigs = $this->configs->getProviderConfigs();
        if (isset($providerConfigs['endpoint'])) {
            $this->endpoint = $providerConfigs['endpoint'];
        }
        // set script name
        $this->scriptName = $_SERVER['SCRIPT_NAME'];
        // set request url
        $this->requestUrl = $_SERVER['REQUEST_URI'];
        // set method
        $this->method = $_SERVER['REQUEST_METHOD'];
        // set timestamp
        $this->timestamp = $_SERVER['REQUEST_TIME'];
        // set url from _url method
        $this->url = $this->_url();
    }

    /**
     * @name _url method, it returns the possible url to process the requests
     *
     * @return string
     */
    private function _url()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @name checkCardNumber method, this method checks the card number to be possible
     *
     * @param string $cardNumber
     * @return string|null
     *
     * @example
     *      $helper = new Helper();
     *      $helper->checkCardNumber('AAAA-BBBB-CCCC-DDDD');
     */
    public function checkCardNumber($cardNumber)
    {
        if (preg_match('/[0-9]{12}/', $cardNumber)) {
            return $cardNumber;
        }
        if (preg_match('/[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}/', $cardNumber)) {
            $cardNumber = str_replace('-', '', $cardNumber);
            return $cardNumber;
        }
        return null;
    }

    /**
     * @name checkPhoneNumber, this method checks the phone number to be possible
     *
     * @param string $phoneNumber
     * @return string|null
     *
     * @example
     *      $helper = new Helper();
     *      $helper->checkPhoneNumber('99801112233');
     */
    public function checkPhoneNumber($phoneNumber): ?string
    {
        if (strlen($phoneNumber) != 0 && $phoneNumber[0] == '+') {
            $phoneNumber = substr($phoneNumber, 1);
            if (preg_match('/[0-9]{12}/', $phoneNumber)) {
                return $phoneNumber;
            }
            return null;
        }
        if (preg_match('/[0-9]{12}/', $phoneNumber)) {
            return $phoneNumber;
        }
        if (preg_match('/[0-9]{9}/', $phoneNumber)) {
            return '998' . $phoneNumber;
        }
        if (preg_match('/[0-9]{8}/', $phoneNumber)) {
            return '9989' . $phoneNumber;
        }
        return null;
    }
}
