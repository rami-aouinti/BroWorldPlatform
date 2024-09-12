<?php

declare(strict_types=1);

namespace App\User\Domain\Entity\Interfaces;

use App\User\Domain\Entity\Address;
use DateTimeInterface;

/**
 * @package App\User
 */
interface ProfileInterface
{
    public function getId(): string;
    public function getPhoto(): ?string;
    public function getBirthday(): ?DateTimeInterface;
    public function getAddress(): ?Address;
    public function getMobile(): ?string;
    public function getDescription(): ?string;
    public function getSexe(): ?string;
    public function getTitle(): ?string;
    public function getFacebookLink(): ?string;
    public function getTwitter(): ?string;
    public function getGoogle(): ?string;
    public function getLinkedIn(): ?string;
    public function getInstagram(): ?string;
}
