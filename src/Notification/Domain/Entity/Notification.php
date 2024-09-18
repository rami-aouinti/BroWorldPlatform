<?php

declare(strict_types=1);

namespace App\Notification\Domain\Entity;

use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\User\Domain\Entity\Traits\Blameable;
use App\User\Domain\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

/**
 * @package App\Notification\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity]
class Notification
{
    use Blameable;
    use Timestampable;
    use Uuid;
    final public const string SET_USER_NOTIFICATION = 'set.UserNotification';

    #[ORM\Id]
    #[ORM\Column(
        name: 'id',
        type: UuidBinaryOrderedTimeType::NAME,
        unique: true,
        nullable: false,
    )]
    #[Groups([
        'Notification',
        'Notification.id',
        self::SET_USER_NOTIFICATION,
    ])]
    private UuidInterface $id;

    #[ORM\Column(type: 'text')]
    #[Groups([
        'Notification',
        'Notification.message',
        self::SET_USER_NOTIFICATION,
    ])]
    private string $message;

    #[ORM\Column(
        name: 'icon',
        type: Types::STRING,
        length: 255,
        nullable: true,
    )]
    #[Groups([
        'Notification',
        'Notification.icon',

        self::SET_USER_NOTIFICATION,
    ])]
    private ?string $icon = null;

    #[ORM\Column(
        name: 'type',
        type: Types::STRING,
        length: 255,
        nullable: true,
    )]
    #[Groups([
        'Notification',
        'Notification.type',

        self::SET_USER_NOTIFICATION,
    ])]
    private ?string $type = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups([
        'Notification',
        'Notification.isRead',
        self::SET_USER_NOTIFICATION,
    ])]
    private bool $isRead;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[Groups([
        'Notification',
        'Notification.user',
        self::SET_USER_NOTIFICATION,
    ])]
    private ?User $user;

    // Getters et setters

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

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }
    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }
    public function getType(): ?string
    {
        return $this->type;
    }

    public function isRead(): bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): void
    {
        $this->isRead = $isRead;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
