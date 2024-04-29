<?php

namespace BoletoSimples;

use Exception;

class BankBillet extends BaseResource
{
    public function duplicate($params = [])
    {
        $response = self::sendRequest('POST', $this->path('duplicate'), ['query' => $params]);

        return $this->parseResponse($response);
    }

    public function pay($params = [])
    {
        $response = self::sendRequest('PUT', $this->path('pay'), ['query' => $params]);

        return $this->parseResponse($response);
    }

    public static function cnpj_cpf($cnpj_cpf)
    {
        if (!$cnpj_cpf) {
            throw new \Exception("Couldn't find " . get_called_class() . ' without an cnpj or cpf.');
        }
        $response = self::sendRequest('GET', 'bank_billets/cnpj_cpf', ['query' => ['q' => $cnpj_cpf]]);
        $collection = [];
        foreach ($response->json() as $attributes) {
            $collection[] = new BankBillet($attributes);
        }

        return $collection;
    }

    public static function status($status)
    {
        if (!$status) {
            throw new \Exception("Couldn't find " . get_called_class() . ' without an status.');
        }
        $response = self::sendRequest('GET', 'bank_billets/status', ['query' => ['q' => $status]]);
        $collection = [];
        foreach ($response->json() as $attributes) {
            $collection[] = new BankBillet($attributes);
        }

        return $collection;
    }

    public static function our_number($our_number)
    {
        if (!$our_number) {
            throw new \Exception("Couldn't find " . get_called_class() . ' without an our_number.');
        }
        $response = self::sendRequest('GET', 'bank_billets/our_number', ['query' => ['q' => $our_number]]);
        $collection = [];
        foreach ($response->json() as $attributes) {
            $collection[] = new BankBillet($attributes);
        }

        return $collection;
    }

    public static function bulk($params)
    {
        $response = self::sendRequest('POST', 'bank_billets/bulk', ['body' => json_encode(['bank_billets' => $params])]);

        return $response->json();
    }

    public static function update($id, $params)
    {
        $response = self::sendRequest('PUT', "bank_billets/{$id}", ['body' => json_encode($params)]);

        return $response->json();
    }

    public static function cancel($id, $reason)
    {
        if (in_array($reason, [1, 2, 3, 4, 5]) === false) {
            throw new Exception('Motivo do cancelamento inválido!');
        }
        $response = self::sendRequest('PUT', "bank_billets/{$id}/cancel", ['body' => json_encode(['cancellation_reason' => $reason])]);

        return $response;
    }
}
