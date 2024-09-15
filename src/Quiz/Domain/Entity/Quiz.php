<?php

declare(strict_types=1);

namespace App\Quiz\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Quiz
 *
 * @package App\Quiz\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Category $category;

    #[ORM\ManyToOne(targetEntity: Difficulty::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Difficulty $difficulty;

    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: Question::class, cascade: ['persist', 'remove'])]
    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public  function getId(): int
    {
        return $this->id;
    }
    public  function setId(int $id):void
    {
        $this->id = $id;
    }
    public  function getTitle(): string
    {
        return $this->title;
    }
    public  function setTitle(string $title):void
    {
        $this->title = $title;
    }
    public  function getCategory(): Category
    {
        return $this->category;
    }
    public  function setCategory(Category $category):void
    {
        $this->category = $category;
    }
    public  function getDifficulty(): Difficulty
    {
        return $this->difficulty;
    }
    public  function setDifficulty(Difficulty $difficulty):void
    {
        $this->difficulty = $difficulty;
    }
    public  function getQuestions(): Collection
    {
        return $this->questions;
    }
    public  function setQuestions(Collection $questions):void
    {
        $this->questions = $questions;
    }

}
