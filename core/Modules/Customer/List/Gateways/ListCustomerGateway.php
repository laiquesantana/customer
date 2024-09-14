<?php

namespace core\Modules\Customer\List\Gateways;

interface ListCustomerGateway
{
    public function findAll(array $filters, string $sort, int $limit, int $offset): array;
}
