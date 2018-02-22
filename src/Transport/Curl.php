<?php
namespace Crall\Transport;


use Crall\Models\Request;

class Curl extends BaseTransport implements TransportInterface {
    protected $request;
    protected $transport;

    public function __construct() {
        $this->transport = curl_init();
    }

    protected function isPost() {
        curl_setopt($this->transport, CURLOPT_POST, true);
    }

    protected function isCustomRequest() {
        curl_setopt($this->transport, CURLOPT_CUSTOMREQUEST, $this->request->getMethod());
    }

    protected function addPayload() {
        if(!$this->request->hasBody()) {
            return;
        }

        curl_setopt($this->transport, CURLOPT_POSTFIELDS, json_encode($this->request->getBody()));
    }

    public function exec(Request $request) {
        $this->request = $request;

        curl_setopt($this->transport, CURLOPT_URL, $this->request->getUrlWithParams());
        curl_setopt($this->transport, CURLOPT_HTTPHEADER, $this->headers());

        curl_setopt($this->transport, CURLOPT_USERAGENT, $this->userAgent());
        curl_setopt($this->transport, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->transport, CURLOPT_VERBOSE, true);
        curl_setopt($this->transport, CURLOPT_HEADER, true);
        curl_setopt($this->transport, CURLOPT_TIMEOUT, 5);
        curl_setopt($this->transport, CURLOPT_SSL_VERIFYPEER, $this->request->verify_ssl);
        curl_setopt($this->transport, CURLOPT_SSL_VERIFYHOST, $this->request->verify_ssl);
        curl_setopt($this->transport, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($this->transport, CURLINFO_HEADER_OUT, true);

        switch($request->getMethod()) {
            case 'POST':
                $this->isPost();
                $this->addPayload();
            break;

            case 'PUT':
                $this->isCustomRequest();
                $this->addPayload();
            break;

            case 'DELETE':
                $this->isCustomRequest();
            break;
        }

        $response = curl_exec($this->transport);
        $headers = curl_getinfo($this->transport);
        curl_close($this->transport);
        die(($response));
    }
}