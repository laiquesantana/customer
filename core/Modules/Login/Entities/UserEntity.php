<?php
namespace app\core\Modules\Login\Entities;

class UserEntity
{
    private int $id;
    private string $username;
    private string $password;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): UserEntity
    {
        $this->id = $id;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): UserEntity
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): UserEntity
    {
        $this->password = $password;
        return $this;
    }


}
