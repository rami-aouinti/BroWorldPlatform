<?php

declare(strict_types=1);

namespace App\Job\Domain\Entity;

use App\General\Domain\Entity\Traits\Timestampable;
use App\Job\Infrastructure\Repository\ApplicantRepository;
use App\Resume\Domain\Entity\Media;
use App\User\Domain\Entity\Traits\Blameable;
use App\User\Domain\Entity\User;
use DateTimeImmutable;
use DateTimeInterface;
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
 * Class Applicant
 *
 * @package App\Job\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity(repositoryClass: ApplicantRepository::class)]
#[ORM\Table(name: 'candidature_applicant')]
class Applicant
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
        'Applicant',
        'Applicant.id',

        self::SET_JOB_APPLICATION,
    ])]
    private UuidInterface $id;

    /**
     * An additional title for the user, like the Job position or Department
     */
    #[ORM\Column(name: 'title', type: 'string', length: 50, nullable: true)]
    #[Assert\Length(max: 50)]
    #[Groups([
        'Applicant',
        'Applicant.title',

        self::SET_JOB_APPLICATION,
    ])]
    private ?string $title = null;

    /**
     * URL to the user avatar, will be auto-generated if empty
     */
    #[ORM\Column(name: 'avatar', type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255, groups: ['Profile'])]
    #[Groups([
        'Applicant',
        'Applicant.avatar',

        self::SET_JOB_APPLICATION,
    ])]
    private ?string $avatar = null;

    #[ORM\Column(
        name: 'first_name',
        type: Types::STRING,
        length: 255,
        nullable: false,
    )]
    #[Groups([
        'Applicant',
        'Applicant.firstName',
        self::SET_JOB_APPLICATION,
    ])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(
        min: 2,
        max: 255,
    )]
    private ?string $firstName = null;


    #[ORM\Column(
        name: 'last_name',
        type: Types::STRING,
        length: 255,
        nullable: false,
    )]
    #[Groups([
        'Applicant',
        'Applicant.lastName',
        self::SET_JOB_APPLICATION,
    ])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(
        min: 2,
        max: 255,
    )]
    private string $lastName = '';

    #[ORM\Column(
        name: 'email',
        type: Types::STRING,
        length: 255,
        nullable: false,
    )]
    #[Groups([
        'Applicant',
        'Applicant.email',

        self::SET_JOB_APPLICATION,
    ])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Email]
    private string $email = '';

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups([self::SET_JOB_APPLICATION])]
    private ?DateTimeInterface $birthday = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_JOB_APPLICATION])]
    private ?string $mobile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_JOB_APPLICATION])]
    private ?string $facebookLink = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_JOB_APPLICATION])]
    private ?string $twitter = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_JOB_APPLICATION])]
    private ?string $google = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_JOB_APPLICATION])]
    private ?string $linkedIn = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_JOB_APPLICATION])]
    private ?string $instagram = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups([
        'Menu',
        'Menu.coverLetter',
        self::SET_JOB_APPLICATION,
    ])]
    private ?string $coverLetter = null;

    #[ORM\ManyToMany(targetEntity: Media::class)]
    #[ORM\JoinTable(name: 'job_application_media')]
    #[Groups([
        'Menu',
        'Menu.medias',
        self::SET_JOB_APPLICATION,
    ])]
    private Collection $medias;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'applicants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $jobPreferences = null;


    /**
     * @throws Throwable
     */
    public function __construct()
    {
        $this->id = $this->createUuid();
        $this->medias = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public  function getTitle(): ?string
    {
        return $this->title;
    }
    public  function setTitle(?string $title):void
    {
        $this->title = $title;
    }
    public  function getAvatar(): ?string
    {
        return $this->avatar;
    }
    public  function setAvatar(?string $avatar):void
    {
        $this->avatar = $avatar;
    }
    public  function getFirstName(): ?string
    {
        return $this->firstName;
    }
    public  function setFirstName(?string $firstName):void
    {
        $this->firstName = $firstName;
    }
    public  function getLastName(): string
    {
        return $this->lastName;
    }
    public  function setLastName(string $lastName):void
    {
        $this->lastName = $lastName;
    }
    public  function getEmail(): string
    {
        return $this->email;
    }
    public  function setEmail(string $email):void
    {
        $this->email = $email;
    }
    public  function getBirthday(): ?DateTimeInterface
    {
        return $this->birthday;
    }
    public  function setBirthday(?DateTimeInterface $birthday):void
    {
        $this->birthday = $birthday;
    }
    public  function getMobile(): ?string
    {
        return $this->mobile;
    }
    public  function setMobile(?string $mobile):void
    {
        $this->mobile = $mobile;
    }
    public  function getFacebookLink(): ?string
    {
        return $this->facebookLink;
    }
    public  function setFacebookLink(?string $facebookLink):void
    {
        $this->facebookLink = $facebookLink;
    }
    public  function getTwitter(): ?string
    {
        return $this->twitter;
    }
    public  function setTwitter(?string $twitter):void
    {
        $this->twitter = $twitter;
    }
    public  function getGoogle(): ?string
    {
        return $this->google;
    }
    public  function setGoogle(?string $google):void
    {
        $this->google = $google;
    }
    public  function getLinkedIn(): ?string
    {
        return $this->linkedIn;
    }
    public  function setLinkedIn(?string $linkedIn):void
    {
        $this->linkedIn = $linkedIn;
    }
    public  function getInstagram(): ?string
    {
        return $this->instagram;
    }
    public  function setInstagram(?string $instagram):void
    {
        $this->instagram = $instagram;
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

    public function getJobPreferences(): ?string
    {
        return $this->jobPreferences;
    }

    public function setJobPreferences(?string $jobPreferences): self
    {
        $this->jobPreferences = $jobPreferences;

        return $this;
    }

    public function getCoverLetter(): ?string
    {
        return $this->coverLetter;
    }

    public function setCoverLetter(?string $coverLetter): self
    {
        $this->coverLetter = $coverLetter;

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

    public function toArray(): array
    {
        return [
            "id"=>$this->getId(),
            "name"=>$this->getFirstName(),
            "username"=>$this->getUser()->getUsername(),
            "jobPreferences"=>$this->getJobPreferences(),
            "createdAt"=>$this->getCreatedAt(),
            "updatedAt"=>$this->getUpdatedAt()
        ];
    }
}
