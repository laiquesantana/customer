<?php
namespace app\core\Modules\Login\Rules;

use app\core\Modules\Login\Entities\UserEntity;

class ValidateUserRule
{
    public function apply(array $data): void
    {
        if (empty($data['username'])) {
            throw new \Exception('Username is required');
        }
        if (empty($data['password'])) {
            throw new \Exception('Password is required');
        }
    }
}
