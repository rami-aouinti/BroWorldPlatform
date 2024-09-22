<?php

declare(strict_types=1);

namespace App\Job\Domain\Entity;

use App\General\Domain\Entity\Traits\Timestampable;
use App\Job\Infrastructure\Repository\CompanyRepository;
use App\User\Domain\Entity\Traits\Blameable;
use App\User\Domain\Entity\User;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use App\General\Domain\Entity\Traits\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Throwable;

/**
 * Class Company
 *
 * @package App\Job\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ORM\Table(name: 'candidature_company')]
class Company
{
    use Blameable;
    use Timestampable;
    use Uuid;

    final public const string SET_JOB_APPLICATION = 'set.JobApplication';

    #[ORM\Id]
    #[ORM\Column(
        name: 'id',
        type: UuidBinaryOrderedTimeType::NAME,
        unique: true,
        nullable: false,
    )]
    #[Groups([
        'Company',
        'Company.id',

        self::SET_JOB_APPLICATION,
    ])]
    private UuidInterface $id;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length( min: 5, max: 255)]
    #[Groups([
        'Company',
        'Company.name',

        self::SET_JOB_APPLICATION,
    ])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
        'Company',
        'Company.description',

        self::SET_JOB_APPLICATION,
    ])]
    private ?string $description = null;

    #[Assert\NotBlank]
    #[Assert\Length( min: 5, max: 255)]
    #[ORM\Column(length: 255)]
    #[Groups([
        'Company',
        'Company.location',

        self::SET_JOB_APPLICATION,
    ])]
    private ?string $location = null;

    #[ORM\Column(name: 'image', type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    #[Groups([
        'Company',
        'Company.image',

        self::SET_JOB_APPLICATION,
    ])]
    private ?string $image = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id", nullable: false)]
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

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

    public  function getImage(): ?string
    {
        return $this->image;
    }
    public  function setImage(?string $image):void
    {
        $this->image = $image;
    }

    public function toArray(): array
    {
        return [
            "id"=>$this->getId(),
            "name"=>$this->getName(),
            "description"=>$this->getDescription(),
            "location"=>$this->getLocation(),
            "username"=>$this->getUser()->getUsername(),
            "image" => $this->getImage(),
            "createdAt"=>$this->getCreatedAt(),
            "updatedAt"=>$this->getUpdatedAt()
        ];
    }
}
