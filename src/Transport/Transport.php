<?php
namespace Crall\Transport;

use Crall\Models\Request;

class Transport {
    protected $http;
    protected $client;

    public function __construct($client) {
        $this->client = $client;
        $this->init();
    }

    protected function init() {
        $this->http = $this->hasCurl() ? new Curl():new Http();
    }

    public function getHttp() {
        return $this->http;
    }

    public function runRequest(Request $request) {
        $this->getHttp()->exec($request);
    }

    protected function hasCurl() {
        return function_exists('curl_version');
    }
}