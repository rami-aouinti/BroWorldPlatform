<?php

declare(strict_types=1);

namespace App\Configuration\Domain\Entity;

use App\Configuration\Domain\Entity\Interfaces\ConfigurationInterface;
use App\General\Domain\Entity\Interfaces\EntityInterface;
use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\User\Domain\Entity\Traits\Blameable;
use App\User\Domain\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Throwable;

/**
 * @package App\Configuration
 */
#[ORM\Entity]
#[ORM\Table(name: 'configuration')]
class Configuration implements EntityInterface, ConfigurationInterface
{

    use Blameable;
    use Timestampable;
    use Uuid;

    final public const string SET_USER_CONFIGURATION = 'set.UserConfiguration';

    #[ORM\Id]
    #[ORM\Column(
        name: 'id',
        type: UuidBinaryOrderedTimeType::NAME,
        unique: true,
        nullable: false,
    )]
    #[Groups([
        'Configuration',
        'Configuration.id',

        self::SET_USER_CONFIGURATION,
    ])]
    private UuidInterface $id;

    #[ORM\Column(
        name: 'configurationKey',
        type: Types::STRING,
        length: 255,
        nullable: false,
    )]
    #[Groups([
        'Configuration',
        'Configuration.configurationKey',

        self::SET_USER_CONFIGURATION,
    ])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $configurationKey = '';

    #[ORM\Column(
        name: 'configurationEntry',
        nullable: true,
    )]
    #[Groups([
        'Configuration',
        'Configuration.configurationEntry',

        self::SET_USER_CONFIGURATION,
    ])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private mixed $configurationEntry = null;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist'] , inversedBy: 'configurations')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

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

    public  function getConfigurationKey(): string
    {
        return $this->configurationKey;
    }
    public  function setConfigurationKey(string $configurationKey):self
    {
        $this->configurationKey = $configurationKey;

        return $this;
    }

    public  function getConfigurationEntry(): mixed
    {
        return $this->configurationEntry;
    }
    public  function setConfigurationEntry(mixed $configurationEntry):self
    {
        $this->configurationEntry = $configurationEntry;

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
