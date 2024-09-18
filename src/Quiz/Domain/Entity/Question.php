<?php

declare(strict_types=1);

namespace App\Quiz\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @package App\Quiz\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Entity]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $text;

    #[ORM\Column(type: 'string', length: 255)]
    private string $correctAnswer;

    #[ORM\Column(type: 'json')]
    private array $incorrectAnswers = [];

    #[ORM\ManyToOne(targetEntity: Quiz::class, inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private Quiz $quiz;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Choice::class, cascade: ['persist', 'remove'])]
    private Collection $choices;

    public function __construct()
    {
        $this->choices = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getText(): string
    {
        return $this->text;
    }
    public function setText(string $text): void
    {
        $this->text = $text;
    }
    public function getCorrectAnswer(): string
    {
        return $this->correctAnswer;
    }
    public function setCorrectAnswer(string $correctAnswer): void
    {
        $this->correctAnswer = $correctAnswer;
    }
    public function getIncorrectAnswers(): array
    {
        return $this->incorrectAnswers;
    }
    public function setIncorrectAnswers(array $incorrectAnswers): void
    {
        $this->incorrectAnswers = $incorrectAnswers;
    }
    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }
    public function setQuiz(Quiz $quiz): void
    {
        $this->quiz = $quiz;
    }
    public function getChoices(): Collection
    {
        return $this->choices;
    }
    public function setChoices(Collection $choices): void
    {
        $this->choices = $choices;
    }
}
