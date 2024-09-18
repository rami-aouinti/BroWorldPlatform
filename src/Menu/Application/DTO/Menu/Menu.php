<?php

declare(strict_types=1);

namespace App\Menu\Application\DTO\Menu;

use App\General\Application\DTO\Interfaces\RestDtoInterface;
use App\General\Application\DTO\RestDto;
use App\General\Domain\Entity\Interfaces\EntityInterface;
use App\Menu\Domain\Entity\Menu as Entity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @package App\Menu
 *
 * @method self|RestDtoInterface get(string $id)
 * @method self|RestDtoInterface patch(RestDtoInterface $dto)
 * @method Entity|EntityInterface update(EntityInterface $entity)
 */
class Menu extends RestDto
{
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 2, max: 255)]
    protected string $title = '';

    protected ?string $prefix = '';

    protected ?string $link = '';

    protected bool $active = false;

    protected ?string $action;

    protected ?int $level;

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): self
    {
        $this->setVisited('title');

        $this->title = $title;

        return $this;
    }
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }
    public function setPrefix(?string $prefix): self
    {
        $this->setVisited('prefix');

        $this->prefix = $prefix;

        return $this;
    }
    public function getLink(): ?string
    {
        return $this->link;
    }
    public function setLink(?string $link): self
    {
        $this->setVisited('link');

        $this->link = $link;

        return $this;
    }
    public function isActive(): bool
    {
        return $this->active;
    }
    public function setActive(bool $active): self
    {
        $this->setVisited('active');

        $this->active = $active;

        return $this;
    }
    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->setVisited('action');

        $this->action = $action;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }
    public function setLevel(?int $level): self
    {
        $this->setVisited('level');

        $this->level = $level;

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
            $this->title = $entity->getTitle();
            $this->prefix = $entity->getPrefix();
            $this->link = $entity->getLink();
            $this->active = $entity->isActive();
            $this->action = $entity->getAction();
            $this->level = $entity->getLevel();
        }

        return $this;
    }
}
