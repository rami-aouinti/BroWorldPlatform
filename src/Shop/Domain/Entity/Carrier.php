<?php

declare(strict_types=1);

namespace App\Shop\Domain\Entity;

use App\General\Domain\Entity\Interfaces\EntityInterface;
use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\Shop\Infrastructure\Repository\CarrierRepository;
use App\User\Domain\Entity\Traits\Blameable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

/**
 * Class Carrier
 *
 * @package App\Shop\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity(repositoryClass: CarrierRepository::class)]
#[ORM\Table(name: 'shop_carrier')]
class Carrier implements EntityInterface
{
    use Blameable;
    use Timestampable;
    use Uuid;

    final public const string SET_SHOP_ADDRESS = 'set.ShopAddress';

    #[ORM\Id]
    #[ORM\Column(
        name: 'id',
        type: UuidBinaryOrderedTimeType::NAME,
        unique: true,
        nullable: false,
    )]
    #[Groups([
        'Carrier',
        'Carrier.id',

        self::SET_SHOP_ADDRESS,
    ])]
    private UuidInterface $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'text')]
    private ?string $description;

    #[ORM\Column(type: 'float')]
    private ?float $price;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCarrierLabel(): ?string
    {
        $price = number_format($this->price/100, 2);
        return "{$this->name}: [br]{$this->description}[br] $price € ";
    }
}
