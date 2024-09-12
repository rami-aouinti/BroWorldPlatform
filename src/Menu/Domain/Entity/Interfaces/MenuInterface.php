<?php

declare(strict_types=1);

namespace App\Menu\Domain\Entity\Interfaces;

/**
 * @package App\Menu
 */
interface MenuInterface
{
    public function getId(): string;

    public function getTitle(): string;

    public function getPrefix(): ?string;
    public function getLink(): ?string;

    public function isActive(): bool;
    public function getAction(): ?string;

    public function getLevel(): ?int;
}
