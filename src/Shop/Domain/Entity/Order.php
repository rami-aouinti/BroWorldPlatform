<?php

declare(strict_types=1);

namespace App\Shop\Domain\Entity;

use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\Shop\Infrastructure\Repository\OrderRepository;
use App\User\Domain\Entity\Traits\Blameable;
use App\User\Domain\Entity\User;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

/**
 * Class Order
 *
 * @package App\Shop\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'shop_order')]
class Order
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
        'Order',
        'Order.id',

        self::SET_SHOP_ADDRESS,
    ])]
    private UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $carrierName;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $carrierPrice;

    #[ORM\Column(type: 'text')]
    private ?string $delivery;

    #[ORM\OneToMany(mappedBy: 'bindedOrder', targetEntity: OrderDetails::class)]
    private ArrayCollection $orderDetails;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $reference;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $stripeSession;

    #[ORM\Column(type: 'integer')]
    private ?int $state;

    /**
     * @throws Throwable
     */
    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
        $this->id = $this->createUuid();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCarrierName(): ?string
    {
        return $this->carrierName;
    }

    public function setCarrierName(string $carrierName): self
    {
        $this->carrierName = $carrierName;

        return $this;
    }

    public function getCarrierPrice(): ?string
    {
        return $this->carrierPrice;
    }

    public function setCarrierPrice(string $carrierPrice): self
    {
        $this->carrierPrice = $carrierPrice;

        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(string $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOderDetail(OrderDetails $oderDetail): self
    {
        if (!$this->orderDetails->contains($oderDetail)) {
            $this->orderDetails[] = $oderDetail;
            $oderDetail->setBindedOrder($this);
        }

        return $this;
    }

    public function removeOderDetail(OrderDetails $oderDetail): self
    {
        if ($this->orderDetails->removeElement($oderDetail)) {
            // set the owning side to null (unless already changed)
            if ($oderDetail->getBindedOrder() === $this) {
                $oderDetail->setBindedOrder(null);
            }
        }

        return $this;
    }

    public function getTotal():float
    {
        $total = 0;
        foreach ($this->getOrderDetails() as $product) {
            $total += $product->getTotal();
        }
        return $total;

    }

    public function getTotalQuantity():float
    {
        $total = 0;
        foreach ($this->getOrderDetails() as $product) {
            $total += $product->getQuantity();
        }
        return $total;

    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getStripeSession(): ?string
    {
        return $this->stripeSession;
    }

    public function setStripeSession(?string $stripeSession): self
    {
        $this->stripeSession = $stripeSession;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }
}
