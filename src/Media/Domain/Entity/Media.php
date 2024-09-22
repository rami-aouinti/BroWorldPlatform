<?php

declare(strict_types=1);

namespace App\Media\Domain\Entity;

use App\General\Domain\Entity\Traits\Timestampable;
use App\General\Domain\Entity\Traits\Uuid;
use App\User\Domain\Entity\Traits\Blameable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

/**
 * @ORM\Entity
 */
#[ORM\Entity]
#[ORM\Table(name: 'media')]
class Media
{
    use Blameable;
    use Timestampable;
    use Uuid;

    #[ORM\Id]
    #[ORM\Column(
        name: 'id',
        type: UuidBinaryOrderedTimeType::NAME,
        unique: true,
        nullable: false,
    )]
    #[Groups([
        'Media',
        'Media.id',
    ])]
    private UuidInterface $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $contextKey;

    #[ORM\Column(type: 'string', length: 255)]
    private string $mimeType;

    #[ORM\Column(type: 'string', length: 50)]
    private string $fileExtension;

    #[ORM\Column(type: 'integer')]
    private int $fileSize;

    #[ORM\Column(type: 'json')]
    private array $metaData;

    #[ORM\Column(type: 'string', length: 2048)]
    private string $path;

    #[ORM\Column(type: 'boolean')]
    private bool $private = false;

    #[ORM\ManyToOne(targetEntity: MediaFolder::class)]
    private MediaFolder $mediaFolder;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: MediaThumbnail::class)]
    private Collection $thumbnails;

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


    public  function getContextKey(): string
    {
        return $this->contextKey;
    }
    public  function setContextKey(string $contextKey):void
    {
        $this->contextKey = $contextKey;
    }
    public  function getMimeType(): string
    {
        return $this->mimeType;
    }
    public  function setMimeType(string $mimeType):void
    {
        $this->mimeType = $mimeType;
    }
    public  function getFileExtension(): string
    {
        return $this->fileExtension;
    }
    public  function setFileExtension(string $fileExtension):void
    {
        $this->fileExtension = $fileExtension;
    }
    public  function getFileSize(): int
    {
        return $this->fileSize;
    }
    public  function setFileSize(int $fileSize):void
    {
        $this->fileSize = $fileSize;
    }
    public  function getMetaData(): array
    {
        return $this->metaData;
    }
    public  function setMetaData(array $metaData):void
    {
        $this->metaData = $metaData;
    }
    public  function getPath(): string
    {
        return $this->path;
    }
    public  function setPath(string $path):void
    {
        $this->path = $path;
    }
    public  function isPrivate(): bool
    {
        return $this->private;
    }
    public  function setPrivate(bool $private):void
    {
        $this->private = $private;
    }
    public  function getMediaFolder(): MediaFolder
    {
        return $this->mediaFolder;
    }
    public  function setMediaFolder(MediaFolder $mediaFolder):void
    {
        $this->mediaFolder = $mediaFolder;
    }
    public  function getThumbnails(): Collection
    {
        return $this->thumbnails;
    }
    public  function setThumbnails(Collection $thumbnails):void
    {
        $this->thumbnails = $thumbnails;
    }
}

