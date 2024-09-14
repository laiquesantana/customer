<?php
namespace app\core\Presenters;

use app\core\Responses\Response;

class JsonResponsePresenter implements PresenterInterface
{
    public function present(Response $response): array
    {
        return [
            'status' => $response->getStatus()->getCode(),
            'message' => $response->getStatus()->getMessage(),
            'data' => $response->getData(),
            'error' => $response->getError(),
            'meta' => $response->getMeta(),
        ];
    }
}
