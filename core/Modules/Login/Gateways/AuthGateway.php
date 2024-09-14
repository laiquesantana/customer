<?php
namespace core\Modules\Login\Gateways;

use core\Modules\Login\Entities\UserEntity;

interface AuthGateway
{
    public function findUserByUsername(string $username): ?UserEntity;
    public function validatePassword(string $username, string $password): ?bool;

}
