<?php
namespace core\Modules\Book\Create;

use app\adapters\ConfigAdapter;
use app\adapters\Http\ClientAdapter;
use core\Modules\Book\Create\Gateways\BookGateway;
use core\Modules\Book\Create\Rules\CreateBookRule;
use core\Modules\Generics\Entities\Status;
use core\Presenters\JsonResponsePresenter;
use core\Responses\Response;
use core\Responses\ResponseInterface;

class UseCase
{
    private Response $response;
    private ClientAdapter $clientAdapter;
    private ConfigAdapter $configAdapter;
    private BookGateway $bookGateway;

    public function __construct(BookGateway $bookGateway,ClientAdapter $clientAdapter, ConfigAdapter $configAdapter)
    {
        $this->clientAdapter = $clientAdapter;
        $this->configAdapter = $configAdapter;
        $this->bookGateway = $bookGateway;

        $this->response = new Response(new JsonResponsePresenter());
    }

    public function execute(array $data): void
    {
        try {
            $book = (new CreateBookRule($this->bookGateway,$this->clientAdapter,$this->configAdapter))($data)->apply();

            $this->response
                ->setStatus(
                    (new Status())->setCode(201)->setMessage('Book created successfully')
                )
                ->setData([$book]);

        } catch (\Exception $e) {
            $this->response
                ->setStatus(
                    (new Status())->setCode(500)->setMessage('Error creating book')
                )
                ->setError($e->getMessage());
        }
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
