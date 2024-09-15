<?php

declare(strict_types=1);

namespace App\Messenger\Domain\Repository\Interfaces;

use App\User\Domain\Entity\User;

/**
 * @package App\Messenger
 */
interface MessageRepositoryInterface
{
    /**
        * @param User $sender
        * @param User $receiver
        * @return mixed
     */
    public function findByUsers(User $sender, User $receiver): mixed;
}
