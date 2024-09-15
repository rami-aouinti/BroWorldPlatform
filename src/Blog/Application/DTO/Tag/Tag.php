<?php

declare(strict_types=1);

namespace App\Blog\Application\DTO\Tag;

use App\General\Application\DTO\Interfaces\RestDtoInterface;
use App\General\Application\DTO\RestDto;
use App\General\Domain\Entity\Interfaces\EntityInterface;
use App\Blog\Domain\Entity\Tag as Entity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @package App\Tag
 *
 * @method self|RestDtoInterface get(string $id)
 * @method self|RestDtoInterface patch(RestDtoInterface $dto)
 * @method Entity|EntityInterface update(EntityInterface $entity)
 */
class Tag extends RestDto
{

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 2, max: 255)]
    protected string $name = '';


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->setVisited('name');
        $this->name = $name;

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
        }

        return $this;
    }
}
