<?php
namespace core\Modules\Customer\Create\Gateways;


use core\Modules\Customer\Create\Entities\CustomerEntity;

interface CustomerGateway
{
    public function save(CustomerEntity $customerEntity): CustomerEntity;
}
