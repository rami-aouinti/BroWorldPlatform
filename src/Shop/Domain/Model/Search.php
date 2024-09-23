<?php

declare(strict_types=1);

namespace App\Shop\Domain\Model;

/**
* Class Search
 * @package App\Shop\Domain\Model
 * @author Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
class Search
{
    /**
     * @var string
     */
    private string $string = '';

    /**
     * @var array
     */
    private array $categories = [];

    /**
     * Get the value of string
     */
    public function getString(): string
    {
        return $this->string;
    }

    /**
     * Set the value of string
     *
     * @param $string
     *
     * @return  self
     */
    public function setString($string): static
    {
        $this->string = $string;

        return $this;
    }

    /**
     * Get the value of categories
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * Set the value of categories
     *
     * @param $categories
     *
     * @return  self
     */
    public function setCategories($categories): static
    {
        $this->categories = $categories;

        return $this;
    }
}
