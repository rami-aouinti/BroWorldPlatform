<?php

declare(strict_types=1);

namespace App\Shop\Domain\Model;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CartFactory
 *
 * @package App\Shop\Domain\Model
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
class CartFactory
{
    public function create(SessionInterface $session): Cart
    {
        return new Cart($session);
    }
}
