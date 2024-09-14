<?php
namespace app\core\Modules\Login\Gateways;

use app\core\Modules\Login\Entities\UserEntity;

interface AuthGateway
{
    public function findUserByUsername(string $username): ?UserEntity;
    public function validatePassword(string $username, string $password): ?bool;

}
