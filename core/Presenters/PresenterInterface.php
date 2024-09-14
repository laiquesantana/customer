<?php
namespace core\Presenters;

use core\Responses\Response;

interface PresenterInterface
{
    public function present(Response $response): array;
}