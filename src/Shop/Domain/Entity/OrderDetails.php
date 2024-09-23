<?php

declare(strict_types=1);

namespace App\Shop\Domain\Entity;

use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\Shop\Infrastructure\Repository\OrderDetailsRepository;
use App\User\Domain\Entity\Traits\Blameable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

/**
 * Class OrderDetails
 *
 * @package App\Shop\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity(repositoryClass: OrderDetailsRepository::class)]
#[ORM\Table(name: 'shop_order_details')]
class OrderDetails
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
        'OrderDetails',
        'OrderDetails.id',

        self::SET_SHOP_ADDRESS,
    ])]
    private UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $bindedOrder;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $product;

    #[ORM\Column(type: 'integer')]
    private ?int $quantity;

    #[ORM\Column(type: 'float')]
    private ?float $price;

    #[ORM\Column(type: 'float')]
    private ?float $total;

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

    public function getBindedOrder(): ?Order
    {
        return $this->bindedOrder;
    }

    public function setBindedOrder(?Order $bindedOrder): self
    {
        $this->bindedOrder = $bindedOrder;

        return $this;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getProduct() . 'x' . $this->getQuantity();
    }
}
