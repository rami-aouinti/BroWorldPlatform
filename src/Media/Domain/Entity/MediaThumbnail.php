<?php

declare(strict_types=1);

namespace App\Media\Domain\Entity;

use App\General\Domain\Entity\Traits\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

/**
 * Class MediaThumbnail
 *
 * @package App\Media\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity]
#[ORM\Table(name: 'media_thumbnail')]
class MediaThumbnail
{
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

    #[ORM\ManyToOne(targetEntity: Media::class, inversedBy: 'thumbnails')]
    private Media $media;

    #[ORM\Column(type: 'integer')]
    private int $width;

    #[ORM\Column(type: 'integer')]
    private int $height;

    #[ORM\Column(type: 'string', length: 2048)]
    private string $path;

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

    public  function getMedia(): Media
    {
        return $this->media;
    }
    public  function setMedia(Media $media):void
    {
        $this->media = $media;
    }
    public  function getWidth(): int
    {
        return $this->width;
    }
    public  function setWidth(int $width):void
    {
        $this->width = $width;
    }
    public  function getHeight(): int
    {
        return $this->height;
    }
    public  function setHeight(int $height):void
    {
        $this->height = $height;
    }
    public  function getPath(): string
    {
        return $this->path;
    }
    public  function setPath(string $path):void
    {
        $this->path = $path;
    }

}
