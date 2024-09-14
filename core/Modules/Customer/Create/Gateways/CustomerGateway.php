<?php
namespace app\core\Modules\Customer\Create\Gateways;


use app\core\Modules\Customer\Create\Entities\CustomerEntity;

interface CustomerGateway
{
    public function save(CustomerEntity $customerEntity): CustomerEntity;
}
