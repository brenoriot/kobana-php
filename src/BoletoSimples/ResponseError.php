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

        $json = json_decode($response->getBody()->getContents(), true);

        if (isset($json['errors'])) {
            if (is_array($json['errors']) === true) {
                foreach ($json['errors'] as $errorTitle => $errorContent)
                {
                    if (is_array($errorContent) === true) {
                        $this->message = $errorTitle . ' - ' . $errorContent[0];
                        throw $this;
                    } else {
                        $this->message = $errorTitle . ' - ' . $errorContent;
                        throw $this;
                    }
                }
            }

            $message = '';
            if (isset($json['errors'][0]['title'])) {
                $message .= $json['errors'][0]['title'] . ' - ';
            }
            if (isset($json['errors'][0]['code'])) {
                $message .= $json['errors'][0]['code'] . ' - ';
            }

            if (isset($json['errors'][0]['detail'])) {
                $message .= $json['errors'][0]['detail'] . ' - ';
            }
            $this->message = $message;

            throw $this;
        }
    }
}
