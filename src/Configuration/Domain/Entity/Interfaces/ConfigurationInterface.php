<?php

declare(strict_types=1);

namespace App\Configuration\Domain\Entity\Interfaces;

/**
 * @package App\Configuration
 */
interface ConfigurationInterface
{
    public function getId(): string;

    public function getConfigurationKey(): string;

    public function getConfigurationEntry(): mixed;
}
