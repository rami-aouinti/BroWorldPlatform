<?php

declare(strict_types=1);

namespace App\Configuration\Application\DTO\Configuration;

use App\General\Application\DTO\Interfaces\RestDtoInterface;
use App\General\Application\DTO\RestDto;
use App\General\Domain\Entity\Interfaces\EntityInterface;
use App\Configuration\Domain\Entity\Configuration as Entity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @package App\Configuration
 *
 * @method self|RestDtoInterface get(string $id)
 * @method self|RestDtoInterface patch(RestDtoInterface $dto)
 * @method Entity|EntityInterface update(EntityInterface $entity)
 */
class Configuration extends RestDto
{

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 2, max: 255)]
    protected string $configurationKey = '';

    #[Assert\NotBlank]
    protected mixed $configurationEntry = null;

    public function getConfigurationKey(): string
    {
        return $this->configurationKey;
    }

    public function setConfigurationKey(string $configurationKey): self
    {
        $this->setVisited('configurationKey');
        $this->configurationKey = $configurationKey;

        return $this;
    }

    public  function getConfigurationEntry(): mixed
    {
        return $this->configurationEntry;
    }
    public  function setConfigurationEntry(mixed $configurationEntry):self
    {
        $this->setVisited('configurationEntry');
        $this->configurationEntry = $configurationEntry;

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
            $this->configurationKey = $entity->getConfigurationKey();
            $this->configurationEntry = $entity->getConfigurationEntry();
        }

        return $this;
    }
}
