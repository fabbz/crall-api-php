<?php

namespace Crall\Transport;

class BaseTransport {
    public function headers() {
        return array(
            'Accept: application/vnd.api+json',
            'Content-Type: application/vnd.api+json',
            'Api-key:' . $this->request->getApiKey()
        );
    }

    public function userAgent() {
        return 'Crall-php-client '.$this->request->getVersion();
    }
}