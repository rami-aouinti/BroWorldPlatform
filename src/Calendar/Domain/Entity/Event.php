<?php

declare(strict_types=1);

namespace App\Calendar\Domain\Entity;

use App\Calendar\Infrastructure\Repository\EventRepository;
use App\User\Domain\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Event
 *
 * @package App\Calendar\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    final public const string SET_USER_EVENT = 'set.UserEvent';

    /**
     * @var int
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        self::SET_USER_EVENT,
    ])]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        self::SET_USER_EVENT,
    ])]
    private string $title;

    #[ORM\Column(type: 'date')]
    #[Groups([
        self::SET_USER_EVENT,
    ])]
    private \DateTimeInterface $start;

    #[ORM\Column(type: 'date')]
    #[Groups([
        self::SET_USER_EVENT,
    ])]
    private \DateTimeInterface $end;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        self::SET_USER_EVENT,
    ])]
    private string $className;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist'] , inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    public  function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getStart(): \DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;
        return $this;
    }

    public function getEnd(): \DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;
        return $this;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function setClassName(string $className): self
    {
        $this->className = $className;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
