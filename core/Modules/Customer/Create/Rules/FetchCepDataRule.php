<?php
namespace core\Modules\Customer\Create\Rules;

use core\Modules\Customer\Create\Gateways\CepGateway;

class FetchCepDataRule
{
    private CepGateway $cepGateway;

    public function __construct(CepGateway $cepGateway)
    {
        $this->cepGateway = $cepGateway;
    }

    public function apply(string $cep): array
    {
        return $this->cepGateway->fetchAddressByCep($cep);
    }
}
