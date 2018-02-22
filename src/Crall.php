<?php
namespace Crall;
require 'autoload.php';
use Crall\Models\Request;

class Crall {
    protected $api_key;
    protected $transport;

    const ENDPOINT = 'https://app.crall.dev/api';
    const VERSION = 'v1';


    public function __construct($api_key) {
        $this->api_key = $api_key;
        $this->transport = new Transport\Transport($this);
    }

    public function post($resource,$options = array()) {
        $request = Request::make('post',$resource,$options);
        return $this->processRequest($request);
    }

    public function put($resource,$options = array()) {
        $request = Request::make('put',$resource,$options);
        return $this->processRequest($request);
    }

    public function get($resource,$options = array()) {
        $request = Request::make('get',$resource,$options);
        return $this->processRequest($request);
    }

    protected function processRequest(Request $request) {
        return $this->transport->runRequest(
            $request->setApiKey($this->api_key)
            ->setVersion(self::VERSION)
            ->setEndpoint(self::ENDPOINT)
        );
    }



}