<?php

namespace app\core\Modules\Customer\Create;

use app\core\Modules\Customer\Create\Entities\CustomerEntity;
use app\core\Modules\Customer\Create\Gateways\CepGateway;
use app\core\Modules\Customer\Create\Gateways\CustomerGateway;
use app\core\Responses\Response;
use app\core\Responses\ResponseInterface;
use app\core\Presenters\JsonResponsePresenter;
use app\core\Modules\Generics\Entities\Status;
class UseCase
{
    private CustomerGateway $customerGateway;
    private CepGateway $cepGateway;
    private ResponseInterface $response;

    public function __construct(
        CustomerGateway $customerGateway,
        CepGateway $cepGateway
    ) {
        $this->customerGateway = $customerGateway;
        $this->cepGateway = $cepGateway;
        $this->response = new Response(new JsonResponsePresenter());
    }

    public function execute(array $data): void
    {
        try {
            $cepData = $this->cepGateway->fetchAddressByCep($data['cep']);

            $customer = new CustomerEntity();
            $customer->name = $data['name'];
            $customer->cpf = $data['cpf'];
            $customer->cep = $data['cep'];
            $customer->address = $cepData['street'];
            $customer->city = $cepData['city'];
            $customer->state = $cepData['state'];
            $customer->number = $data['number'];
            $customer->complement = $data['complement'] ?? null;
            $customer->gender = $data['gender'];

            $this->customerGateway->save($customer);

            $this->response
                ->setStatus(
                    (new Status())->setCode(201)->setMessage('Customer created successfully')
                )
                ->setData([$customer]);
        } catch (\Exception $e) {
            $this->response
                ->setStatus(
                    (new Status())->setCode(500)->setMessage('Failed to create customer')
                )
                ->setError($e->getMessage());
        }
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
