<?php

declare(strict_types=1);

namespace App\Shop\Domain\Entity;

use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\Shop\Infrastructure\Repository\ProductRepository;
use App\User\Domain\Entity\Traits\Blameable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\User\Domain\Entity\User;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

/**
 * Class Cart
 *
 * @package App\Shop\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity]
#[ORM\Table(name: 'shop_cart')]
class Cart
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
        'Cart',
        'Cart.id',
    ])]
    private UuidInterface $id;

    #[ORM\Column(type: 'integer')]
    private ?int $quantity;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'carts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartItem::class, cascade: ['persist', 'remove'])]
    private Collection $cartItems;

    private ProductRepository $productRepository;

    /**
     * @throws Throwable
     */
    public function __construct()
    {
        $this->id = $this->createUuid();
        $this->cartItems = new ArrayCollection();
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

    public  function getQuantity(): ?int
    {
        return $this->quantity;
    }
    public  function setQuantity(?int $quantity):void
    {
        $this->quantity = $quantity;
    }

    public function addCartItem(Product $product, int $quantity): self
    {
        $cartItem = new CartItem($this, $product, $quantity);
        $this->cartItems[] = $cartItem;

        return $this;
    }

    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    /**
     * @param Cart $cart
     *
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     * @return array
     */
    public function getDetails(Cart $cart): array
    {
        $cartProducts = [
            'products' => [],
            'totals' => [
                'quantity' => 0,
                'price' => 0,
            ],
        ];

        foreach ($cart->getCartItems() as $cartItem) {
            $currentProduct = $this->productRepository->find($cartItem->getProduct());
            if ($currentProduct) {
                $cartProducts['products'][] = [
                    'product' => $currentProduct,
                    'quantity' => $cartItem->getQuantity()
                ];
                $cartProducts['totals']['quantity'] += $cartItem->getQuantity();
                $cartProducts['totals']['price'] += $cartItem->getQuantity() * $currentProduct->getPrice();
            }
        }
        return $cartProducts;
    }
}
