<?php

namespace BoletoSimples;

class Configuration
{
    public $environment;
    public $application_id;
    public $application_secret;
    public $access_token;
    private $environments_uri = [
        'sandbox' => 'https://api-sandbox.kobana.com.br/v1/',
        'production' => 'https://api.kobana.com.br/v1/',
    ];

    public function __construct($params = [])
    {
        $default_environment = getenv('BOLETOSIMPLES_ENV') ? getenv('BOLETOSIMPLES_ENV') : 'sandbox';
        $default_application_id = getenv('BOLETOSIMPLES_APP_ID') ? getenv('BOLETOSIMPLES_APP_ID') : null;
        $default_application_secret = getenv('BOLETOSIMPLES_APP_SECRET') ? getenv('BOLETOSIMPLES_APP_SECRET') : null;
        $default_access_token = getenv('BOLETOSIMPLES_ACCESS_TOKEN') ? getenv('BOLETOSIMPLES_ACCESS_TOKEN') : null;

        $this->environment = isset($params['environment']) ? $params['environment'] : $default_environment;
        $this->application_id = isset($params['application_id']) ? $params['application_id'] : $default_application_id;
        $this->application_secret = isset($params['application_secret']) ? $params['application_secret'] : $default_application_secret;
        $this->access_token = isset($params['access_token']) ? $params['access_token'] : $default_access_token;
    }

    public function userAgent()
    {
        return 'Kobana PHP Client v'.\BoletoSimples::VERSION.' (suporte@kobana.com.br)';
    }

    public function hasAccessToken()
    {
        return null != $this->access_token;
    }

    public function baseUri()
    {
        return $this->environments_uri[$this->environment];
    }
}
