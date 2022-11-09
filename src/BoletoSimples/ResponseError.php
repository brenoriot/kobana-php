<?php

namespace BoletoSimples;

class ResponseError extends \Exception
{
    /**
     * GuzzleHttp\Message\Response object.
     */
    public $response;

    /**
     * Constructor method.
     *
     * @param mixed $response
     */
    public function __construct($response)
    {
        $this->response = $response;

        $json = $response->json();
        if (isset($json['error'])) {
            $this->message = $json['error'];

            throw $this;
        }
    }
}
