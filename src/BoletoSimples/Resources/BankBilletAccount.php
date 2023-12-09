<?php

namespace BoletoSimples;

class BankBilletAccount extends BaseResource
{
    public static function ask($bankBilletId)
    {
        if (!$bankBilletId) {
            throw new \Exception("Couldn't find ".get_called_class().' without an id for wallet.');
        }
        $response = self::sendRequest('GET', "bank_billet_accounts/{$bankBilletId}/ask");

        return new BankBilletAccount($response->json());
    }

    public static function delete($bankBilletId)
    {
        if (!$bankBilletId) {
            throw new \Exception("Couldn't find ".get_called_class().' without an id for wallet.');
        }
        self::sendRequest('DELETE', "bank_billet_accounts/{$bankBilletId}");
    }
}
