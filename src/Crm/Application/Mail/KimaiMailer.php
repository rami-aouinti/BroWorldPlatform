<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Application\Mail;

use App\Crm\Application\Service\Configuration\MailConfiguration;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

/**
 * Class KimaiMailer
 *
 * @package App\Crm\Application\Mail
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
final class KimaiMailer implements MailerInterface
{
    public function __construct(private readonly MailConfiguration $configuration, private readonly MailerInterface $mailer)
    {
    }

    public function send(RawMessage $message, Envelope $envelope = null): void
    {
        if ($message instanceof Email && \count($message->getFrom()) === 0) {
            $message->from($this->configuration->getFromAddress());
        }

        $this->mailer->send($message);
    }
}
