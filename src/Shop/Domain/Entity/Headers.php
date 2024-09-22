<?php

declare(strict_types=1);

namespace App\Shop\Domain\Entity;

use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\Shop\Infrastructure\Repository\HeadersRepository;
use App\User\Domain\Entity\Traits\Blameable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

/**
 * Class Headers
 *
 * @package App\Shop\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity(repositoryClass: HeadersRepository::class)]
#[ORM\Table(name: 'shop_headers')]
class Headers
{
    use Blameable;
    use Timestampable;
    use Uuid;

    final public const string SET_SHOP_ADDRESS = 'set.ShopAddress';

    #[ORM\Id]
    #[ORM\Column(
        name: 'id',
        type: UuidBinaryOrderedTimeType::NAME,
        unique: true,
        nullable: false,
    )]
    #[Groups([
        'Headers',
        'Headers.id',

        self::SET_SHOP_ADDRESS,
    ])]
    private UuidInterface $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title;

    #[ORM\Column(type: 'text')]
    private ?string $content;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $btnTitle;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $btnUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $image;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getBtnTitle(): ?string
    {
        return $this->btnTitle;
    }

    public function setBtnTitle(string $btnTitle): self
    {
        $this->btnTitle = $btnTitle;

        return $this;
    }

    public function getBtnUrl(): ?string
    {
        return $this->btnUrl;
    }

    public function setBtnUrl(string $btnUrl): self
    {
        $this->btnUrl = $btnUrl;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
