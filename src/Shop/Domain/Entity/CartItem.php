<?php

declare(strict_types=1);

namespace App\Shop\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 */
#[ORM\Entity]
#[ORM\Table(name: 'shop_cart_item')]
class CartItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        'CartItem',
        'CartItem.id',
    ])]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'cartItems')]
    #[Groups([
        'CartItem',
        'CartItem.cart',
    ])]
    private Cart $cart;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[Groups([
        'CartItem',
        'CartItem.product',
    ])]
    private Product $product;

    #[ORM\Column(type: 'integer')]
    #[Groups([
        'CartItem',
        'CartItem.quantity',
    ])]
    private int $quantity;

    public function __construct(Cart $cart, Product $product, int $quantity)
    {
        $this->cart = $cart;
        $this->product = $product;
        $this->quantity = $quantity;
    }

    // Getters et setters

    public function getId(): int
    {
        return $this->id;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
