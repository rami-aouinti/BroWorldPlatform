<?php

declare(strict_types=1);

namespace App\Job\Domain\Entity;

use App\General\Domain\Entity\Traits\Timestampable;
use App\Job\Infrastructure\Repository\JobRepository;
use App\User\Domain\Entity\Traits\Blameable;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use App\General\Domain\Entity\Traits\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Throwable;

/**
 * Class Job
 *
 * @package App\Job\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity(repositoryClass: JobRepository::class)]
#[ORM\Table(name: 'candidature_job')]
class Job
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
        'Job',
        'Job.id',

        self::SET_JOB_APPLICATION,
    ])]
    private UuidInterface $id;

    #[Assert\NotBlank]
    #[Assert\Length( min: 5, max: 255)]
    #[ORM\Column(length: 255)]
    #[Groups([
        'Job',
        'Job.title',

        self::SET_JOB_APPLICATION,
    ])]
    private ?string $title = null;

    #[Assert\NotBlank]
    #[Assert\Length( min: 5)]
    #[ORM\Column(type: Types::TEXT)]
    #[Groups([
        'Job',
        'Job.description',

        self::SET_JOB_APPLICATION,
    ])]
    private ?string $description = null;

    #[Assert\NotBlank]
    #[Assert\Length( min: 5)]
    #[ORM\Column(type: Types::TEXT)]
    #[Groups([
        'Job',
        'Job.requiredSkills',

        self::SET_JOB_APPLICATION,
    ])]
    private ?string $requiredSkills = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'Job',
        'Job.experience',

        self::SET_JOB_APPLICATION,
    ])]
    private ?string $experience = null;

    #[Assert\NotBlank]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'Job',
        'Job.company',

        self::SET_JOB_APPLICATION,
    ])]
    private ?Company $company = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: "jobs")]
    #[ORM\JoinTable(name: 'job_category')]
    #[Groups(['Job', 'Job.categories'])]
    private Collection $categories;

    /**
     * @throws Throwable
     */
    public function __construct()
    {
        $this->id = $this->createUuid();
        $this->categories = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRequiredSkills(): ?string
    {
        return $this->requiredSkills;
    }

    public function setRequiredSkills(string $requiredSkills): self
    {
        $this->requiredSkills = $requiredSkills;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(?string $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->getJobs()->add($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->getJobs()->removeElement($this);
        }

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function toArray(): array
    {
        return [
            "id"=>$this->getId(),
            "title"=>$this->getTitle(),
            "description"=>$this->getDescription(),
            "requiredSkills"=>$this->getRequiredSkills(),
            "experience"=>$this->getExperience(),
            "company"=>$this->getCompany()->toArray(),
            "createdAt"=>$this->getCreatedAt(),
            "updatedAt"=>$this->getUpdatedAt()
        ];
    }

    public function __toString() : string
    {
        return $this->title;
    }


}
