<?php

namespace BoletoSimples;

class Remittance extends BaseResource
{
    public static function bulk($params = [])
    {
        $response = self::sendRequest('POST', 'remittances/bulk', ['json' => ['remittance' => $params]]);

        return $response->json();
    }
}
