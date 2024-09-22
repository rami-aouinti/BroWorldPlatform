<?php

declare(strict_types=1);

namespace App\Notification\Application\Service;

use App\User\Domain\Entity\User;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

/**
 * @package App\Notification\Application\Service
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
class NotificationService
{
    private HubInterface $hub;

    public function __construct(HubInterface $hub)
    {
        $this->hub = $hub;
    }

    /**
     * @param User $user
     * @param      $message
     *
     * @return void
     */
    public function sendNotification(User $user, $message): void
    {
        $update = new Update(
            '/user/notification/' . $user->getUsername(),
            json_encode([
                'message' => $message,
            ])
        );
        $this->hub->publish($update);
    }
}
