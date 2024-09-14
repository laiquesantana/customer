<?php

namespace core\Modules\Customer\List;


use core\Modules\Customer\Create\Gateways\CustomerGateway;
use core\Modules\Generics\Entities\Status;
use core\Presenters\JsonResponsePresenter;
use core\Responses\Response;
use core\Responses\ResponseInterface;

class UseCase
{
    private CustomerGateway $listCustomerGateway;
    private Response $response;

    public function __construct(CustomerGateway $listCustomerGateway)
    {
        $this->listCustomerGateway = $listCustomerGateway;
        $this->response = new Response(new JsonResponsePresenter());

    }

    public function execute(array $params): void
    {
        $filters = [
            'name' => $params['name'] ?? null,
            'cpf' => $params['cpf'] ?? null,
        ];
        $sort = $params['sort'] ?? 'name';
        $limit = (int)($params['limit'] ?? 10);
        $offset = (int)($params['offset'] ?? 0);

        try {
            $customers = $this->listCustomerGateway->findAll($filters, $sort, $limit, $offset);
            $total = count($customers);

            $this->response
                ->setStatus(
                    (new Status())->setCode(200)->setMessage('Customers retrieved successfully')
                )
                ->setData($customers)
                ->setMeta(['total' => $total]);

        } catch (\Exception $e) {
            $this->response
                ->setStatus(
                    (new Status())->setCode(500)->setMessage('Error retrieving customers')
                )
                ->setError($e->getMessage());
        }
    }


    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
