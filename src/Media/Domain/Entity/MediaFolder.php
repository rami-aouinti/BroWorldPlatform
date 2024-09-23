<?php

declare(strict_types=1);

namespace App\Media\Domain\Entity;

use App\General\Domain\Entity\Traits\Uuid;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Throwable;

/**
 * Class MediaFolder
 *
 * @package App\Media\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity]
#[ORM\Table(name: 'media_folder')]
class MediaFolder
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

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: MediaFolder::class)]
    private ?MediaFolder $parent;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: MediaFolder::class)]
    private Collection $children;

    #[ORM\Column(type: 'boolean')]
    private bool $useParentConfiguration = true;

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

    public  function getName(): string
    {
        return $this->name;
    }
    public  function setName(string $name):void
    {
        $this->name = $name;
    }
    public  function getParent(): ?MediaFolder
    {
        return $this->parent;
    }
    public  function setParent(?MediaFolder $parent):void
    {
        $this->parent = $parent;
    }
    public  function getChildren(): Collection
    {
        return $this->children;
    }
    public  function setChildren(Collection $children):void
    {
        $this->children = $children;
    }
    public  function isUseParentConfiguration(): bool
    {
        return $this->useParentConfiguration;
    }
    public  function setUseParentConfiguration(bool $useParentConfiguration):void
    {
        $this->useParentConfiguration = $useParentConfiguration;
    }
}
