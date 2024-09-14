<?php
namespace app\core\Modules\Customer\Create\Rules;

use app\core\Modules\Customer\Create\Gateways\CepGateway;

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
