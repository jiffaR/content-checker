<?php
namespace Freinir\ContentChecker\Services;

use MCurl\Client;

class CurlService {

    private static $instance = null;

    /**
     * @return CurlService
     */
    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new Client();
            self::$instance->setCurlOption([CURLOPT_SSL_VERIFYHOST => false]);
            self::$instance->setCurlOption([CURLOPT_SSL_VERIFYPEER => false]);
            self::$instance->setCurlOption([CURLOPT_FOLLOWLOCATION => true]);
        }

        return self::$instance;
    }

}