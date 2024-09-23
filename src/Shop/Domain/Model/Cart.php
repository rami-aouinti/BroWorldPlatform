<?php

declare(strict_types=1);

namespace App\Shop\Domain\Model;

use App\Shop\Infrastructure\Repository\ProductRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
* Class Cart
 * @package App\Shop\Domain\Model
 * @author Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
class Cart
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    /**
     * Crée un tableau associatif id => quantité et le stocke en session
     *
     * @param string $id
     *
     * @return void
     */
    public function add(string $id):void
    {
        $cart = $this->session->get('cart', []);

        if (empty($cart[$id])) {
            $cart[$id] = 1;
        } else {
            $cart[$id]++;
        }

        $this->session->set('cart', $cart);

    }

    /**
     * Récupère le panier en session
     *
     * @return array
     */
    public function get(): array
    {
        return $this->session->get('cart');
    }


    /**
     * Supprime entièrement le panier en session
     *
     * @return void
     */
    public function remove(): void
    {
        $this->session->remove('cart');
    }


    /**
     * Supprime entièrement un produit du panier (quelque soit sa quantité)
     *
     * @param string $id
     * @return void
     */
    public function removeItem(string $id): void
    {
        $cart = $this->session->get('cart', []);
        unset($cart[$id]);
        $this->session->set('cart', $cart);
    }


    /**
     * Diminue de 1 la quantité d'un produit
     *
     * @param string $id
     * @return void
     */
    public function decreaseItem(string $id): void
    {
        $cart = $this->session->get('cart', []);
        if ($cart[$id] < 2) {
            unset($cart[$id]);
        } else {
            $cart[$id]--;
        }
        $this->session->set('cart', $cart);
    }


    /**
     * Récupère le panier en session, puis récupère les objets produits de la bdd
     * et calcule les totaux
     *
     * @param ProductRepository $productRepository
     *
     * @return array
     */
    public function getDetails(ProductRepository $productRepository): array
    {
        $cartProducts = [
            'products' => [],
            'totals' => [
                'quantity' => 0,
                'price' => 0,
            ],
        ];

        $cart = $this->session->get('cart', []);
        if ($cart) {
            foreach ($cart as $id => $quantity) {
                try {
                    $currentProduct = $productRepository->find($id);
                } catch (OptimisticLockException|TransactionRequiredException|ORMException $e) {
                }
                if ($currentProduct) {
                    $cartProducts['products'][] = [
                        'product' => $currentProduct,
                        'quantity' => $quantity
                    ];
                    $cartProducts['totals']['quantity'] += $quantity;
                    $cartProducts['totals']['price'] += $quantity * $currentProduct->getPrice();
                }
            }
        }
        return $cartProducts;
    }
}
