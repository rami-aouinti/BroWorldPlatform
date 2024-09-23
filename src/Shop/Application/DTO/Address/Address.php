<?php

declare(strict_types=1);

namespace App\Shop\Application\DTO\Address;

use App\General\Application\DTO\Interfaces\RestDtoInterface;
use App\General\Application\DTO\RestDto;
use App\General\Domain\Entity\Interfaces\EntityInterface;
use App\Shop\Domain\Entity\Address as Entity;

/**
 * @package App\Address
 *
 * @method self|RestDtoInterface get(string $id)
 * @method self|RestDtoInterface patch(RestDtoInterface $dto)
 * @method Entity|EntityInterface update(EntityInterface $entity)
 */
class Address extends RestDto
{
    private ?string $name;

    private ?string $firstname;

    private ?string $lastname;

    private ?string $company;

    private ?string $address;

    private ?string $postal;

    private ?string $city;

    private ?string $country;

    private ?string $phone;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->setVisited('name');

        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->setVisited('firstname');

        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->setVisited('lastname');

        $this->lastname = $lastname;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->setVisited('company');

        $this->company = $company;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->setVisited('address');

        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->setVisited('city');

        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->setVisited('country');

        $this->country = $country;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->setVisited('phone');

        $this->phone = $phone;

        return $this;
    }

    public function getPostal(): ?string
    {
        return $this->postal;
    }

    public function setPostal(string $postal): self
    {
        $this->setVisited('postal');

        $this->postal = $postal;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param EntityInterface|Entity $entity
     */
    public function load(EntityInterface $entity): self
    {
        if ($entity instanceof Entity) {
            $this->id = $entity->getId();
            $this->name = $entity->getName();
            $this->firstname = $entity->getFirstname();
            $this->lastname = $entity->getLastname();
            $this->company = $entity->getCompany();
            $this->address = $entity->getAddress();
            $this->postal = $entity->getPostal();
            $this->city = $entity->getCity();
            $this->country = $entity->getCountry();
            $this->phone = $entity->getPhone();
        }

        return $this;
    }
}
