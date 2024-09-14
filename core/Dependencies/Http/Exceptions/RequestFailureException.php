<?php
namespace core\Dependencies\Http\Exceptions;

use Throwable;

class RequestFailureException extends \Exception
{
    protected string $endpoint;

    public function __construct($message = "", Throwable $previous = null, $code = 0, string $endpoint = '')
    {
        $this->endpoint = $endpoint;
        parent::__construct($message, $code, $previous);
    }

    public function setEndpoint(string $endpoint): self
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }
}
