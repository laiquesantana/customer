<?php
namespace app\core\Presenters;

use app\core\Responses\Response;

interface PresenterInterface
{
    public function present(Response $response): array;
}