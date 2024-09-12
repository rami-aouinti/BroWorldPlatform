<?php

declare(strict_types=1);

namespace App\Menu\Domain\Entity;

use App\General\Domain\Entity\Interfaces\EntityInterface;
use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\Menu\Domain\Entity\Interfaces\MenuInterface;
use App\User\Domain\Entity\Traits\Blameable;
use App\User\Domain\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Attribute\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

/**
 * @package App\Menu
 */
#[ORM\Entity]
#[ORM\Table(name: 'menu')]
class Menu implements EntityInterface, MenuInterface
{
    use Blameable;
    use Timestampable;
    use Uuid;

    final public const string SET_USER_MENU = 'set.UserMenu';

    #[ORM\Id]
    #[ORM\Column(
        name: 'id',
        type: UuidBinaryOrderedTimeType::NAME,
        unique: true,
        nullable: false,
    )]
    #[Groups([
        'Menu',
        'Menu.id',

        self::SET_USER_MENU,
    ])]
    private UuidInterface $id;

    #[ORM\Column(
        name: 'title',
        type: Types::STRING,
        length: 255,
        nullable: false,
    )]
    #[Groups([
        'Menu',
        'Menu.title',

        self::SET_USER_MENU,
    ])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $title;

    #[ORM\Column(
        name: 'prefix',
        type: Types::STRING,
        length: 255,
        nullable: true,
    )]
    #[Groups([
        'Menu',
        'Menu.prefix',

        self::SET_USER_MENU,
    ])]
    private ?string $prefix = null;

    #[ORM\Column(
        name: 'link',
        type: Types::STRING,
        length: 255,
        nullable: true,
    )]
    #[Groups([
        'Menu',
        'Menu.link',

        self::SET_USER_MENU,
    ])]
    private ?string $link = null;

    #[ORM\Column(
        name: 'active',
        type: Types::BOOLEAN
    )]
    #[Groups([
        'Menu',
        'Menu.active',

        self::SET_USER_MENU,
    ])]
    private bool $active = false;

    #[ORM\Column(
        name: 'action',
        type: Types::STRING,
        length: 255,
        nullable: true,
    )]
    #[Groups([
        'Menu',
        'Menu.action',

        self::SET_USER_MENU,
    ])]
    private ?string $action = '';

    #[ORM\Column(
        name: 'level',
        type: Types::INTEGER,
        nullable: true,
    )]
    #[Groups([
        'Menu',
        'Menu.level',

        self::SET_USER_MENU,
    ])]
    private ?int $level;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[Groups([
        'Menu',
        'Menu.parent',

        self::SET_USER_MENU,
    ])]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class, cascade: ['persist', 'remove'])]
    private Collection $children;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'menus')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    /**
     * @throws Throwable
     */
    public function __construct()
    {
        $this->id = $this->createUuid();
        $this->children = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title):self
    {
        $this->title = $title;
        return $this;
    }
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }
    public function setPrefix(?string $prefix):self
    {
        $this->prefix = $prefix;
        return $this;
    }
    public function getLink(): ?string
    {
        return $this->link;
    }
    public function setLink(?string $link):self
    {
        $this->link = $link;
        return $this;
    }
    public  function isActive(): bool
    {
        return $this->active;
    }
    public function setActive(bool $active):self
    {
        $this->active = $active;
        return $this;
    }
    public function getAction(): ?string
    {
        return $this->action;
    }

    public  function setAction(?string $action):self
    {
        $this->action = $action;
        return $this;
    }

    public  function getLevel(): ?int
    {
        return $this->level;
    }
    public  function setLevel(?int $level):self
    {
        $this->level = $level;
        return $this;
    }

    public function getParent(): ?Menu
    {
        return $this->parent;
    }
    public function setParent(?Menu $parent):self
    {
        $this->parent = $parent;
        return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Menu $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Menu $child): self
    {
        if ($this->children->removeElement($child)) {
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public  function getUser(): ?User
    {
        return $this->user;
    }
    public  function setUser(?User $user):void
    {
        $this->user = $user;
    }
}
