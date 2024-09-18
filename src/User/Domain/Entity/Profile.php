<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\General\Domain\Entity\Interfaces\EntityInterface;
use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\User\Domain\Entity\Interfaces\ProfileInterface;
use App\User\Domain\Entity\Traits\Blameable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

#[ORM\Entity]
#[ORM\Table(name: 'profile')]
class Profile implements EntityInterface, ProfileInterface
{
    use Blameable;
    use Timestampable;
    use Uuid;
    final public const string SET_PROFILE = 'set.Profile';

    #[ORM\Id]
    #[ORM\Column(
        name: 'id',
        type: UuidBinaryOrderedTimeType::NAME,
        unique: true,
        nullable: false,
    )]
    #[Groups([
        'Profile',
        'Profile.id',

        self::SET_PROFILE,
    ])]
    private UuidInterface $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_PROFILE])]
    private ?string $photo = null;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups([self::SET_PROFILE])]
    private ?DateTimeInterface $birthday = null;

    #[ORM\OneToOne(targetEntity: Address::class, cascade: ['persist', 'remove'])]
    #[Groups([self::SET_PROFILE])]
    private ?Address $address = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_PROFILE])]
    private ?string $mobile = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups([self::SET_PROFILE])]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_PROFILE])]
    private ?string $sexe = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_PROFILE])]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_PROFILE])]
    private ?string $facebookLink = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_PROFILE])]
    private ?string $twitter = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_PROFILE])]
    private ?string $google = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_PROFILE])]
    private ?string $linkedIn = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::SET_PROFILE])]
    private ?string $instagram = null;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }
    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }
    public function getBirthday(): ?DateTimeInterface
    {
        return $this->birthday;
    }
    public function setBirthday(?DateTimeInterface $birthday): void
    {
        $this->birthday = $birthday;
    }
    public function getAddress(): ?Address
    {
        return $this->address;
    }
    public function setAddress(?Address $address): void
    {
        $this->address = $address;
    }
    public function getMobile(): ?string
    {
        return $this->mobile;
    }
    public function setMobile(?string $mobile): void
    {
        $this->mobile = $mobile;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
    public function getSexe(): ?string
    {
        return $this->sexe;
    }
    public function setSexe(?string $sexe): void
    {
        $this->sexe = $sexe;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }
    public function getFacebookLink(): ?string
    {
        return $this->facebookLink;
    }
    public function setFacebookLink(?string $facebookLink): void
    {
        $this->facebookLink = $facebookLink;
    }
    public function getTwitter(): ?string
    {
        return $this->twitter;
    }
    public function setTwitter(?string $twitter): void
    {
        $this->twitter = $twitter;
    }
    public function getGoogle(): ?string
    {
        return $this->google;
    }
    public function setGoogle(?string $google): void
    {
        $this->google = $google;
    }
    public function getLinkedIn(): ?string
    {
        return $this->linkedIn;
    }
    public function setLinkedIn(?string $linkedIn): void
    {
        $this->linkedIn = $linkedIn;
    }
    public function getInstagram(): ?string
    {
        return $this->instagram;
    }
    public function setInstagram(?string $instagram): void
    {
        $this->instagram = $instagram;
    }
}
