<?php
namespace core\Modules\Customer\Create\Entities;
class CustomerEntity
{
    public int $id;
    public string $name;
    public string $cpf;
    public string $cep;
    public string $address;
    public int $number;
    public string $city;
    public string $state;
    public string $complement;
    public string $gender;

    public function getComplement(): string
    {
        return $this->complement;
    }

    public function setComplement(string $complement): CustomerEntity
    {
        $this->complement = $complement;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): CustomerEntity
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CustomerEntity
    {
        $this->name = $name;
        return $this;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): CustomerEntity
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function getCep(): string
    {
        return $this->cep;
    }

    public function setCep(string $cep): CustomerEntity
    {
        $this->cep = $cep;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): CustomerEntity
    {
        $this->address = $address;
        return $this;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): CustomerEntity
    {
        $this->number = $number;
        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): CustomerEntity
    {
        $this->city = $city;
        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): CustomerEntity
    {
        $this->state = $state;
        return $this;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): CustomerEntity
    {
        $this->gender = $gender;
        return $this;
    }

}
