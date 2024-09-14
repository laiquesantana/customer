<?php
namespace core\Modules\Book\List\Gateways;

interface ListBookGateway
{
    public function findAll($filters, $sort, $limit, $offset): array;
}
