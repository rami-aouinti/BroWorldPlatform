<?php

declare(strict_types=1);

namespace App\Job\Domain\Entity;

use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\User\Domain\Entity\Traits\Blameable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Throwable;

/**
 * Class Category
 *
 * @package App\Job\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity]
#[ORM\Table(name: 'candidature_category')]
class Category
{
    use Uuid;
    use Blameable;
    use Timestampable;

    final public const string SET_JOB_APPLICATION = 'set.JobApplication';

    #[ORM\Id]
    #[ORM\Column(
        name: 'id',
        type: UuidBinaryOrderedTimeType::NAME,
        unique: true,
        nullable: false,
    )]
    #[Groups([
        'Job',
        'Job.id',

        self::SET_JOB_APPLICATION,
    ])]
    private UuidInterface $id;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    #[ORM\Column(length: 255)]
    #[Groups(['Category', 'Category.name'])]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Job::class, mappedBy: 'categories', cascade: ["persist"])]
    private Collection $jobs;

    /**
     * @throws Throwable
     */
    public function __construct()
    {
        $this->id = $this->createUuid();
        $this->jobs = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    // Getters and setters
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getJobs(): Collection
    {
        return $this->jobs;
    }
}
