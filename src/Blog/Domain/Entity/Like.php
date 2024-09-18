<?php

declare(strict_types=1);

namespace App\Blog\Domain\Entity;

use App\User\Domain\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Like
 *
 * @package App\Blog\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity]
#[ORM\Table(name: 'symfony_demo_like')]
class Like
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'likes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Post $post = null;

    #[ORM\ManyToOne(targetEntity: Comment::class, inversedBy: 'likes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Comment $comment = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public  function getId(): ?int
    {
        return $this->id;
    }
    public  function setId(?int $id):void
    {
        $this->id = $id;
    }
    public  function getPost(): ?Post
    {
        return $this->post;
    }
    public  function setPost(?Post $post):void
    {
        $this->post = $post;
    }
    public  function getComment(): ?Comment
    {
        return $this->comment;
    }
    public  function setComment(?Comment $comment):void
    {
        $this->comment = $comment;
    }
    public  function getUser(): ?User
    {
        return $this->user;
    }
    public  function setUser(?User $user):void
    {
        $this->user = $user;
    }

}
