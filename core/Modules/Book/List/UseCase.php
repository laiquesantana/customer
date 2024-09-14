<?php
namespace core\Modules\Book\List;

use core\Modules\Book\List\Gateways\ListBookGateway;
use core\Modules\Book\List\Rules\ListBookRule;
use core\Modules\Generics\Entities\Status;
use core\Presenters\JsonResponsePresenter;
use core\Responses\Response;
use core\Responses\ResponseInterface;

class UseCase
{
    private Response $response;
    private ListBookGateway $listBookGateway;

    public function __construct(ListBookGateway $listBookGateway)
    {
        $this->listBookGateway = $listBookGateway;
        $this->response = new Response(new JsonResponsePresenter());
    }

    public function execute(array $params): void
    {
        try {
            $books = (new ListBookRule($this->listBookGateway))($params)->apply();
            $total = count($books);

            $this->response
                ->setStatus(
                    (new Status())->setCode(200)->setMessage('Books retrieved successfully')
                )
                ->setData($books)
                ->setMeta(['total' => $total]);

        } catch (\Exception $e) {
            $this->response
                ->setStatus(
                    (new Status())->setCode(500)->setMessage('Error retrieving books')
                )
                ->setError($e->getMessage());
        }
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
