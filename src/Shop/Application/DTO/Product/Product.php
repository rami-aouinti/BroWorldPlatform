<?php

declare(strict_types=1);

namespace App\Shop\Application\DTO\Product;

use App\General\Application\DTO\Interfaces\RestDtoInterface;
use App\General\Application\DTO\RestDto;
use App\General\Application\Validator\Constraints as GeneralAppAssert;
use App\General\Domain\Entity\Interfaces\EntityInterface;
use App\General\Domain\Enum\Language;
use App\General\Domain\Enum\Locale;
use App\Tool\Application\Validator\Constraints as ToolAppAssert;
use App\Tool\Domain\Service\Interfaces\LocalizationServiceInterface;
use App\Shop\Domain\Entity\Product as Entity;
use Symfony\Component\Validator\Constraints as Assert;

use function array_map;

/**
 * @package App\Product
 *
 * @method self|RestDtoInterface get(string $id)
 * @method self|RestDtoInterface patch(RestDtoInterface $dto)
 * @method Entity|EntityInterface update(EntityInterface $entity)
 */
class Product extends RestDto
{

    private ?string $name;

    private ?string $slug;

    private ?string $image;

    private ?string $subtitle;

    private ?string $description;

    private ?float $price;

    private ?bool $isInHome;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->setVisited('name');

        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->setVisited('slug');

        $this->slug = $slug;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->setVisited('image');

        $this->image = $image;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->setVisited('subtitle');

        $this->subtitle = $subtitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->setVisited('description');

        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->setVisited('price');

        $this->price = $price;

        return $this;
    }

    public function getIsInHome(): ?bool
    {
        return $this->isInHome;
    }

    public function setIsInHome(bool $isInHome): self
    {
        $this->setVisited('isInHome');

        $this->isInHome = $isInHome;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param EntityInterface|Entity $entity
     */
    public function load(EntityInterface $entity): self
    {
        if ($entity instanceof Entity) {
            $this->id = $entity->getId();
            $this->name = $entity->getName();
            $this->slug = $entity->getSlug();
            $this->image = $entity->getImage();
            $this->description = $entity->getDescription();
            $this->subtitle = $entity->getSubtitle();
            $this->price = $entity->getPrice();
            $this->isInHome = $entity->getIsInHome();
        }

        return $this;
    }
}
