<?php
namespace app\core\Modules\Customer\Gateways;


use app\core\Modules\Customer\UseCases\Entities\CustomerEntity;

interface CustomerRepositoryInterface
{
    public function save(CustomerEntity $customer): CustomerEntity;
    public function findAll($filters, $sort, $limit, $offset): array;
}
