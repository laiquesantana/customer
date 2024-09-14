<?php
namespace app\repositories;

use app\core\Modules\Customer\Create\Entities\CustomerEntity;
use app\core\Modules\Customer\Create\Gateways\CustomerGateway;
use app\core\Modules\Customer\List\Gateways\ListCustomerGateway;
use app\models\Customer;

class CustomerRepository implements CustomerGateway, ListCustomerGateway
{
    public function save(CustomerEntity $customerEntity): CustomerEntity
    {
        $model = new Customer();
        $model->setAttributes([
            'name' => $customerEntity->getName(),
            'cpf' => $customerEntity->getCpf(),
            'cep' => $customerEntity->getCep(),
            'address' => $customerEntity->getAddress(),
            'number' => $customerEntity->getNumber(),
            'city' => $customerEntity->getCity(),
            'state' => $customerEntity->getState(),
            'complement' => $customerEntity->getComplement(),
            'gender' => $customerEntity->getGender(),
        ]);

        if ($model->save()) {
            $customerEntity->id = $model->id;
            return $customerEntity;
        } else {
            throw new \Exception('Failed to save customer: ' . json_encode($model->getErrors()));
        }
    }

    public function findAll($filters, $sort, $limit, $offset): array
    {
        $query = Customer::find();

        if (isset($filters['name'])) {
            $query->andFilterWhere(['like', 'name', $filters['name']]);
        }
        if (isset($filters['cpf'])) {
            $query->andFilterWhere(['cpf' => $filters['cpf']]);
        }

        // Apply sorting
        $query->orderBy($sort);

        // Apply pagination
        $query->limit($limit)->offset($offset);

        $models = $query->all();
        $customers = [];
        foreach ($models as $model) {
            $customer = new CustomerEntity();
            $customer->id = $model->id;
            $customer->name = $model->name;
            $customer->cpf = $model->cpf;
            $customer->cep = $model->cep;
            $customer->address = $model->address;
            $customer->number = $model->number;
            $customer->city = $model->city;
            $customer->state = $model->state;
            $customer->complement = $model->complement;
            $customer->gender = $model->gender;

            $customers[] = $customer;
        }

        return $customers;
    }
}
