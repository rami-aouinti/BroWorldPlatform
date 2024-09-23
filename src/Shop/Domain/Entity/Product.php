<?php

declare(strict_types=1);

namespace App\Shop\Domain\Entity;

use App\General\Domain\Entity\Interfaces\EntityInterface;
use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\Media\Domain\Entity\Media;
use App\Shop\Infrastructure\Repository\ProductRepository;
use App\User\Domain\Entity\Traits\Blameable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

/**
 * Class Product
 *
 * @package App\Shop\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'shop_product')]
class Product implements EntityInterface
{
    use Blameable;
    use Timestampable;
    use Uuid;

    final public const string SET_SHOP_PRODUCT = 'set.ShopProduct';

    #[ORM\Id]
    #[ORM\Column(
        name: 'id',
        type: UuidBinaryOrderedTimeType::NAME,
        unique: true,
        nullable: false,
    )]
    #[Groups([
        'Product',
        'Product.id',

        self::SET_SHOP_PRODUCT,
    ])]
    private UuidInterface $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        'Product',
        'Product.name',

        self::SET_SHOP_PRODUCT,
    ])]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        'Product',
        'Product.slug',

        self::SET_SHOP_PRODUCT,
    ])]
    private ?string $slug;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        'Product',
        'Product.image',

        self::SET_SHOP_PRODUCT,
    ])]
    private ?string $image;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        'Product',
        'Product.subtitle',

        self::SET_SHOP_PRODUCT,
    ])]
    private ?string $subtitle;

    #[ORM\Column(type: 'text')]
    #[Groups([
        'Product',
        'Product.description',

        self::SET_SHOP_PRODUCT,
    ])]
    private ?string $description;

    #[ORM\Column(type: 'float')]
    #[Groups([
        'Product',
        'Product.price',

        self::SET_SHOP_PRODUCT,
    ])]
    private ?float $price;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'Product',
        'Product.category',

        self::SET_SHOP_PRODUCT,
    ])]
    private ?Category $category;

    #[ORM\Column(type: 'boolean')]
    #[Groups([
        'Product',
        'Product.isInHome',

        self::SET_SHOP_PRODUCT,
    ])]
    private ?bool $isInHome;

    #[ORM\ManyToMany(targetEntity: Media::class)]
    #[ORM\JoinTable(name: 'product_media')]
    #[Groups([
        'Product',
        'Product.medias',

        self::SET_SHOP_PRODUCT,
    ])]
    private Collection $medias;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: CartItem::class)]
    private Collection $cartItems;

    /**
     * @throws Throwable
     */
    public function __construct()
    {
        $this->id = $this->createUuid();
        $this->medias = new ArrayCollection();
        $this->cartItems = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getIsInHome(): ?bool
    {
        return $this->isInHome;
    }

    public function setIsInHome(bool $isInHome): self
    {
        $this->isInHome = $isInHome;

        return $this;
    }

    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        $this->medias->removeElement($media);

        return $this;
    }

    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }
}
