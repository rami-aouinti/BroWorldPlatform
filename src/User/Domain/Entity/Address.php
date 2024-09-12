<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\General\Domain\Entity\Interfaces\EntityInterface;
use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\User\Domain\Entity\Interfaces\AddressInterface;
use App\User\Domain\Entity\Traits\Blameable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

#[ORM\Entity]
#[ORM\Table(name: 'address')]
class Address implements EntityInterface, AddressInterface
{
    use Blameable;
    use Timestampable;
    use Uuid;

    #[ORM\Id]
    #[ORM\Column(
        name: 'id',
        type: UuidBinaryOrderedTimeType::NAME,
        unique: true,
        nullable: false,
    )]
    #[Groups([
        'Address',
        'Address.id',

        Profile::SET_PROFILE,
    ])]
    private UuidInterface $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([Profile::SET_PROFILE])]
    private string $street;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([Profile::SET_PROFILE])]
    private string $city;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([Profile::SET_PROFILE])]
    private string $country;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([Profile::SET_PROFILE])]
    private string $housenumber;

    #[ORM\Column(type: 'string', length: 10)]
    #[Groups([Profile::SET_PROFILE])]
    private string $postcode;

    /**
     * @throws Throwable
     */
    public function __construct()
    {
        $this->id = $this->createUuid();
    }


    public function getId(): string
    {
        return $this->id->toString();
    }

    public  function getStreet(): string
    {
        return $this->street;
    }
    public  function setStreet(string $street):self
    {
        $this->street = $street;

        return $this;
    }
    public  function getCity(): string
    {
        return $this->city;
    }
    public  function setCity(string $city):self
    {
        $this->city = $city;

        return $this;
    }
    public  function getCountry(): string
    {
        return $this->country;
    }
    public  function setCountry(string $country):self
    {
        $this->country = $country;

        return $this;
    }
    public  function getHousenumber(): string
    {
        return $this->housenumber;
    }
    public  function setHousenumber(string $housenumber):self
    {
        $this->housenumber = $housenumber;

        return $this;
    }
    public  function getPostcode(): string
    {
        return $this->postcode;
    }
    public  function setPostcode(string $postcode):self
    {
        $this->postcode = $postcode;

        return $this;
    }
}
