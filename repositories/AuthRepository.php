<?php
namespace app\repositories;
use core\Modules\Login\Gateways\AuthGateway;
use core\Modules\Login\Entities\UserEntity;
use app\models\User;

class AuthRepository implements AuthGateway
{
    public function findUserByUsername(string $username): ?UserEntity
    {
        $user = User::findOne(['username' => $username]);

        if ($user) {
            $userEntity = new UserEntity();
            $userEntity->setId($user->id);
            $userEntity->setUsername($user->username);
            return $userEntity;
        }

        return null;
    }

    public function validatePassword(string $username, string $password): ?bool
    {
        $user = User::findOne(['username' => $username]);

        if ($user && $user->validatePassword($password)) {
            return true;
        }

        return false;
    }
}
