<?php

namespace Freinir\ContentChecker;

use Freinir\ContentChecker\Services\CurlService;

abstract class AbstractChecker {

    protected $apiUrl;

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
        $this->client = CurlService::getInstance();
    }
}