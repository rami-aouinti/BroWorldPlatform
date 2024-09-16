<?php

declare(strict_types=1);

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Application\Service\Utils;

use App\User\Domain\Entity\Interfaces\UserInterface;

/**
 *
 */
interface EquatableInterface
{
    public function isEqualTo(UserInterface $compare): bool;
}
