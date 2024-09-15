<?php

declare(strict_types=1);

namespace App\Messenger\Domain\Entity;

use App\General\Domain\Entity\Interfaces\EntityInterface;
use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\User\Domain\Entity\Traits\Blameable;
use App\User\Domain\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

/**
 * Class Message
 *
 * @package App\Messenger\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity]
#[ORM\Table(name: 'message')]
class Message implements EntityInterface
{
    use Blameable;
    use Timestampable;
    use Uuid;

    final public const string SET_USER_MESSAGE = 'set.UserMessage';

    #[ORM\Id]
    #[ORM\Column(
        name: 'id',
        type: UuidBinaryOrderedTimeType::NAME,
        unique: true,
        nullable: false,
    )]
    #[Groups([
        'Message',
        'Message.id',

        self::SET_USER_MESSAGE,
    ])]
    private UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[Groups([
        'Message',
        'Message.sentAt',

        self::SET_USER_MESSAGE,
    ])]
    private User $sender;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[Groups([
        'Message',
        'Message.sentAt',

        self::SET_USER_MESSAGE,
    ])]
    private User $receiver;

    #[ORM\Column(type: 'text')]
    #[Groups([
        'Message',
        'Message.content',

        self::SET_USER_MESSAGE,
    ])]
    private string $content;

    #[ORM\Column(type: 'datetime')]
    #[Groups([
        'Message',
        'Message.sentAt',

        self::SET_USER_MESSAGE,
    ])]
    private DateTime $sentAt;

    /**
     * @throws Throwable
     */
    public function __construct()
    {
        $this->id = $this->createUuid();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public  function getSender(): User
    {
        return $this->sender;
    }
    public  function setSender(User $sender):void
    {
        $this->sender = $sender;
    }
    public  function getReceiver(): User
    {
        return $this->receiver;
    }
    public  function setReceiver(User $receiver):void
    {
        $this->receiver = $receiver;
    }
    public  function getContent(): string
    {
        return $this->content;
    }
    public  function setContent(string $content):void
    {
        $this->content = $content;
    }
    public  function getSentAt(): DateTime
    {
        return $this->sentAt;
    }
    public  function setSentAt(DateTime $sentAt):void
    {
        $this->sentAt = $sentAt;
    }
}
