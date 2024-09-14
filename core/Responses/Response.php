<?php
namespace app\core\Responses;

use app\core\Modules\Generics\Entities\Status;
use app\core\Presenters\PresenterInterface;

class Response implements ResponseInterface
{
    private Status $status;
    private array $data = [];
    private string $error = '';
    private array $meta = [];
    private PresenterInterface $presenter;

    public function __construct(PresenterInterface $presenter)
    {
        $this->presenter = $presenter;
    }

    public function setStatus(Status $status): ResponseInterface
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setError(string $error): self
    {
        $this->error = $error;
        return $this;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function setMeta(array $meta): self
    {
        $this->meta = $meta;
        return $this;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function present(): array
    {
        return $this->presenter->present($this);
    }
}
