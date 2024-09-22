<?php

declare(strict_types=1);

namespace App\Job\Domain\Entity;

use App\General\Domain\Entity\Traits\Timestampable;
use App\Job\Infrastructure\Repository\JobApplicationRepository;
use App\Resume\Domain\Entity\Media;
use App\User\Domain\Entity\Traits\Blameable;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use App\General\Domain\Entity\Traits\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Throwable;

/**
 * Class JobApplication
 *
 * @package App\Job\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity(repositoryClass: JobApplicationRepository::class)]
#[ORM\Table(name: 'candidature_job_application')]
class JobApplication
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
        'Menu',
        'Menu.id',

        self::SET_JOB_APPLICATION,
    ])]
    private UuidInterface $id;

    #[Assert\NotBlank]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Job $job = null;

    #[Assert\NotBlank]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Applicant $applicant = null;

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

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getApplicant(): ?Applicant
    {
        return $this->applicant;
    }

    public function setApplicant(?Applicant $applicant): self
    {
        $this->applicant = $applicant;

        return $this;
    }

    public function toArray(): array
    {
        return [
            "id"=>$this->getId(),
            "applicant"=>$this->getApplicant()->toArray(),
            "job"=>$this->getJob()->toArray(),
            "createdAt"=>$this->getCreatedAt(),
            "updatedAt"=>$this->getUpdatedAt()
        ];
    }
}
