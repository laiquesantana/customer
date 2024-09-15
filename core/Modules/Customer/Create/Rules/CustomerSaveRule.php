<?php

namespace core\Modules\Customer\Create\Rules;

use core\Modules\Customer\Create\Entities\CustomerEntity;
use core\Modules\Customer\Create\Gateways\CustomerGateway;

class CustomerSaveRule
{
    private CustomerGateway $customerGateway;

    public function __construct(CustomerGateway $customerGateway)
    {
        $this->customerGateway = $customerGateway;
    }

    public function apply(CustomerEntity $customer): CustomerEntity
    {
        return $this->customerGateway->save($customer);
    }
}
