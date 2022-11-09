<?php

namespace BoletoSimples;

class LastRequest
{
    /**
     * Content of response header Total.
     */
    public $total;

    /**
     * Content of response header X-Ratelimit-Limit.
     */
    public $ratelimit_limit;

    /**
     * Content of response header X-Ratelimit-Remaining.
     */
    public $ratelimit_remaining;

    /**
     * Array with links returned on header Link.
     */
    public $links;

    /**
     * GuzzleHttp\Message\Request object.
     */
    public $request;

    /**
     * GuzzleHttp\Message\Response object.
     */
    public $response;

    /**
     * Constructor method.
     *
     * @param mixed $request
     * @param mixed $response
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;

        $this->total = $response->getHeader('Total');
        $this->ratelimit_limit = $response->getHeader('X-Ratelimit-Limit');
        $this->ratelimit_remaining = $response->getHeader('X-Ratelimit-Remaining');
        $this->links = $this->getLinks($response);
    }

    private function getLinks($response)
    {
        $link_header = $response->getHeader('Link');
        if (null == $link_header) {
            return [];
        }
        $links = [];
        foreach (explode(', ', $link_header) as $link) {
            preg_match('/rel=\"(.*)\"/', $link, $matches);
            $key = $matches[1];
            preg_match('/\<(.*)\>/', $link, $matches);
            $value = $matches[1];
            $links[$key] = $value;
        }

        return $links;
    }
}
