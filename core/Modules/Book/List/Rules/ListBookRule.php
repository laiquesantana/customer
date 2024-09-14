<?php
namespace core\Modules\Book\List\Rules;

use core\Modules\Book\List\Gateways\ListBookGateway;

class ListBookRule
{
    private ListBookGateway $listBookGateway;
    private ?array $params;

    public function __construct(ListBookGateway $listBookGateway)
    {
        $this->listBookGateway = $listBookGateway;
    }

    public function __invoke(?array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function apply(): array
    {
        $filters = [
            'title' => $this->params['title'] ?? null,
            'author' => $this->params['author'] ?? null,
            'isbn' => $this->params['isbn'] ?? null,
        ];
        $sort = $this->params['sort'] ?? 'title';
        $limit = (int)($this->params['limit'] ?? 10);
        $offset = (int)($this->params['offset'] ?? 0);

        return $this->listBookGateway->findAll($filters, $sort, $limit, $offset);
    }
}
