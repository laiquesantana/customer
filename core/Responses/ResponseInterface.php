<?php

namespace app\core\Responses;

use app\core\Modules\Generics\Entities\Status;

interface ResponseInterface
{
    public function setStatus(Status $status): self;
    public function getStatus(): Status;

    public function setData(array $data): self;
    public function getData(): array;

    public function setError(string $error): self;
    public function getError(): string;

    public function setMeta(array $meta): self;
    public function getMeta(): array;

    public function present(): array;
}
