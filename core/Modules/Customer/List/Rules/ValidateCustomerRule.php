<?php
namespace app\core\Modules\Customer\List\Rules;


class ValidateCustomerRule
{
    public function apply(array $data): void
    {
        // Basic validations
        if (empty($data['name'])) {
            throw new \Exception('Name is required');
        }
        if (empty($data['cpf']) || !preg_match('/^\d{11}$/', $data['cpf'])) {
            throw new \Exception('Invalid CPF');
        }
        if (empty($data['cep']) || !preg_match('/^\d{8}$/', $data['cep'])) {
            throw new \Exception('Invalid CEP');
        }
        if (empty($data['number'])) {
            throw new \Exception('Number is required');
        }
        if (empty($data['gender']) || !in_array($data['gender'], ['M', 'F'])) {
            throw new \Exception('Invalid gender');
        }
    }
}
