# Kobana PHP

Antes de qualquer coisa, este é um fork do [projeto original](https://github.com/BoletoSimples/boletosimples-php), já obsoleto, e que visa atualizar principalmente urls, pós troca de `boletosimples` para `kobana`

[![Lates Stable Version](https://img.shields.io/packagist/v/operandbr/kobana.svg)][packagist]
[![License: MIT](https://img.shields.io/packagist/l/operandbr/kobana.svg)][packagist_license]

[packagist]: https://packagist.org/packages/kobana/kobana
[packagist_license]: https://github.com/operandbr/kobana-php/blob/master/LICENSE

Biblioteca PHP para acessar informações do [Kobana](https://www.kobana.com.br/) através da [API](https://developers.kobana.com.br/reference/visao-geral).

## Instalação

### Requisitos

PHP 5.5 ou superior

### Usando [Composer](https://getcomposer.org/)

Crie um arquivo chamado `composer.json` com o seguinte conteúdo:

```json
{
    "minimum-stability": "dev",
    "prefer-stable" : true,
    "require": {
        "operandbr/kobana": "0.0.10"
    }
}
```

Execute:

```bash
composer install
```

## Configuração

```php
<?php

require_once 'vendor/autoload.php';

BoletoSimples::configure([
    "environment" => 'production', // default: 'sandbox'
    "access_token" => 'access-token'
]);

?>
```

### Variáveis de ambiente

Você também pode configurar as variáveis de ambiente a seguir e não será necessário chamar `BoletoSimples::configure`

```bash
ENV['BOLETOSIMPLES_ENV']
ENV['BOLETOSIMPLES_APP_ID']
ENV['BOLETOSIMPLES_APP_SECRET']
ENV['BOLETOSIMPLES_ACCESS_TOKEN']
```

## Exemplos

### Boletos Bancários

```php
// Criar um boleto
$bank_billet = BoletoSimples\BankBillet::create([
    'amount' => 9.01,
    'description' => 'Despesas do contrato 0012',
    'expire_at' => '2014-01-01',
    'customer_address' => 'Rua quinhentos',
    'customer_address_complement' => 'Sala 4',
    'customer_address_number' => '111',
    'customer_city_name' => 'Rio de Janeiro',
    'customer_cnpj_cpf' => '012.345.678-90',
    'customer_email' => 'cliente@example.com',
    'customer_neighborhood' => 'Sao Francisco',
    'customer_person_name' => 'Joao da Silva',
    'customer_person_type' => 'individual',
    'customer_phone_number' => '2112123434',
    'customer_state' => 'RJ',
    'customer_zipcode' => '12312-123'
]);

// Criar um novo boleto instanciando o objeto
$bank_billet = new BoletoSimples\BankBillet(['amount' => 199.99, 'expire_at' => '2020-01-01']);
$bank_billet->description = 'Cobrança XPTO';
$bank_billet->save();

// Mensagens de erro na criação do boleto
$bank_billet = BoletoSimples\BankBillet::create(['amount' => 9.1]);
print_r($bank_billet->response_errors);
// Array
// (
//     [expire_at] => Array
//         (
//             [0] => não pode ficar em branco
//             [1] => não é uma data válida
//         )
//
//     [customer_person_name] => Array
//         (
//             [0] => não pode ficar em branco
//         )
//
//     [customer_cnpj_cpf] => Array
//         (
//             [0] => não pode ficar em branco
//         )
//
//     [description] => Array
//         (
//             [0] => não pode ficar em branco
//         )
//
//     [customer_zipcode] => Array
//         (
//             [0] => não pode ficar em branco
//         )
//
// )


// Pegar informações de um boleto
$bank_billet = BoletoSimples\BankBillet::find(1); // onde 1 é o id do boleto.

// Se o não for encontrado nenhum boleto com o id informado, uma exceção será levantada com a mensagem 'Not Found'

// Listar os boletos
$bank_billets = BoletoSimples\BankBillet::all(['page' => 1, 'per_page' => 50]);
foreach($bank_billets as $bank_billet) {
  print_r($bank_billet->attributes());
}

 // Após realizar a chamada na listagem, você terá acesso aos seguintes dados:

BoletoSimples::$last_request->total // número total de boletos
BoletoSimples::$last_request->links['first'] // url da primeira página
BoletoSimples::$last_request->links['prev'] // url da página anterior
BoletoSimples::$last_request->links['next'] // url da próxima página
BoletoSimples::$last_request->links['last'] // url da última página

// Cancelar um boleto
$bank_billet = BoletoSimples\BankBillet::find(1);
$bank_billet->cancel();
```

### Clientes

```php
// Criar um cliente
$customer = BoletoSimples\Customer::create([
    'person_name' => "Joao da Silva",
    'cnpj_cpf' => "321.315.217-07",
    'email' => "cliente@example.com",
    'address' => "Rua quinhentos",
    'city_name' => "Rio de Janeiro",
    'state' => "RJ",
    'neighborhood' => "bairro",
    'zipcode' => "12312-123",
    'address_number' => "111",
    'address_complement' => "Sala 4",
    'phone_number' => "2112123434"
]);

// Criar um novo cliente instanciando o objeto
$customer = new BoletoSimples\Customer();
$customer->cnpj_cpf = '828.788.171-41';
$customer->person_name = 'Joao da Silva';
$customer->zipcode = '12312-123';
$customer->save();

// Mensagens de erro na criação do cliente
$customer = BoletoSimples\Customer::create(['person_name' => 'Joao da Silva', 'cnpj_cpf' => '321.315.217-07']);
print_r($customer->response_errors);
// ["cnpj_cpf"=>["já está em uso"],"zipcode"=>["não pode ficar em branco"]]

// Pegar informações de um cliente
$customer = BoletoSimples\Customer::find(1); // onde 1 é o id do cliente.

// Se o não for encontrado nenhum cliente com o id informado, uma exceção será levantada com a mensagem 'Not Found'

// Listar os clientes
$customers = BoletoSimples\Customer::all(['page' => 1, 'per_page' => 50]);
foreach($customers as $customer) {
    print_r($customer->attributes());
}

 // Após realizar a chamada na listagem, você terá acesso aos seguintes dados:

BoletoSimples::$last_request->total // número total de clientes
BoletoSimples::$last_request->links['first'] // url da primeira página
BoletoSimples::$last_request->links['prev'] // url da página anterior
BoletoSimples::$last_request->links['next'] // url da próxima página
BoletoSimples::$last_request->links['last'] // url da última página
```

### Extrato

```php
// Listar todas as transações
$transactions = BoletoSimples\Transaction::all();
foreach($transactions as $transaction) {
    print_r($transaction->attributes());
}
```

### Extras

```php
// Dados do usuário logado
$userinfo = BoletoSimples\Extra::userinfo();
```

### Remessas

```php
// Criar uma remessa
$remittance = BoletoSimples\Remittance::create([
    'bank_billet_account_id' => "1"
]);
```

### Retornos

```php
// Enviar um retorno
// Caminho para o seu arquivo
$path = realpath(dirname(__FILE__) . '/cnab.txt');
$discharge = BoletoSimples\Discharge::create([
    'content' => file_get_contents($path)
]);
```

## Desenvolvendo

Instale as dependências

```bash
composer install
```

Rode os testes

```bash
./vendor/bin/phpunit
```

## Licença

Esse código é livre para ser usado dentro dos termos da licença [MIT license](http://www.opensource.org/licenses/mit-license.php).

## Bugs, Issues, Agradecimentos, etc

Comentários são bem-vindos. Envie seu feedback através do [issue tracker do GitHub](http://github.com/operandbr/kobana-php/issues)