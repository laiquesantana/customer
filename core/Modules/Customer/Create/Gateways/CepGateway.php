<?php
namespace app\core\Modules\Customer\Create\Gateways;

interface CepGateway
{
    public function fetchAddressByCep(string $cep): array;
}
