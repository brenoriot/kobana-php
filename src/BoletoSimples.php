<?php

class BoletoSimples
{
    public const VERSION = '0.0.10';
    public static $configuration;
    public static $last_request;

    public static function configure($params = [])
    {
        BoletoSimples::$configuration = new BoletoSimples\Configuration($params);
    }
}

BoletoSimples::configure();
