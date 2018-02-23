<?php
namespace Crall\Transport;

use Crall\Models\Request;

class Http extends BaseTransport implements TransportInterface {
    protected $transport = [];
    protected $request;

    protected function addPayload() {
        if(!$this->request->hasBody()) {
            return;
        }

        $this->transport['http']['content'] = json_encode($this->request->getBody());
    }

    public function exec(Request $request) {
        $this->request = $request;

        $this->transport = array(
            'http' => array(
                'header'  => $this->headers(),
                'method'  => $this->request->getMethod(),
            ),
            'ssl'=>array(
                'verify_peer'=>$this->request->verify_ssl,
                'verify_peer_name'=>$this->request->verify_ssl,
            )
        );

        $this->addPayload();
        $response = @file_get_contents($this->request->getUrlWithParams(), false, stream_context_create($this->transport));

        if($response === false) {
            return false;
        }

        $response = json_decode($response,true);
        if($response) {
            return false;
        }

        return $response;
    }
}