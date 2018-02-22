<?php
namespace Crall\Models;

class Request {
    protected $method;
    protected $body = false;
    protected $params = [];
    protected $resource;
    protected $api_key;
    protected $endpoint;
    protected $version;
    public $verify_ssl = false;

    public function __construct() {
        return $this;
    }

    public function setApiKey($api_key) {
        $this->api_key = $api_key;
        return $this;
    }

    protected function getApiPath() {
        return $this->endpoint.'/'.$this->getVersion();
    }

    protected function getResourceUrl() {
        return $this->getApiPath().'/'.$this->getResource();
    }

    public function getUrlWithParams() {
        $url = $this->getResourceUrl();

        if($this->hasParams()) {
            $url .= http_build_query($this->params);
        }

        return $url;
    }

    public function getVersion() {
        return $this->version;
    }

    public function setEndpoint($value) {
        $this->endpoint = $value;
        return $this;
    }

    public function setVersion($value) {
        $this->version = $value;
        return $this;
    }

    public function getApiKey() {
        return $this->api_key;
    }

    public function getResource() {
        return $this->resource;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getBody() {
        return $this->body;
    }

    public function getParams() {
        return $this->params;
    }

    public function hasParams() {
        return !empty($this->params);
    }

    public function isJson() {
        return !is_array($this->body);
    }

    public function hasBody() {
        return $this->body === false ? false:true;
    }

    public function setMethod($value) {
        $this->method = strtoupper($value);
        return $this;
    }

    public function setOptions($options) {
        if(isset($options['params'])) {
            $request->setParams($options['params']);
        }

        if(isset($options['body'])) {
            $this->body = $options['body'];
        }

        return $this;
    }

    public function setParams($value) {
        $this->params = $value;
        return $this;
    }

    public function setResource($value) {
        $this->resource = $value;
        return $this;
    }

    public static function make($method,$resource,$options) {
        return (new static())
                    ->setMethod($method)
                    ->setResource($resource)
                    ->setOptions($options);
        }
}