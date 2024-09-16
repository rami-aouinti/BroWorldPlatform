<?php

declare(strict_types=1);

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Transport\EventSubscriber;

use App\Crm\Application\Mail\KimaiMailer;
use App\Crm\Transport\Event\EmailEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Class EmailSubscriber
 * @package App\Crm\Transport\EventSubscriber
 * @author Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
final class EmailSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly KimaiMailer $mailer)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            EmailEvent::class => ['onMailEvent', 100],
        ];
    }

    public function onMailEvent(EmailEvent $event): void
    {
        $this->mailer->send($event->getEmail());
    }
}
