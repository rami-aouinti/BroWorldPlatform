<?php

declare(strict_types=1);

namespace App\User\Domain\Entity\Interfaces;

/**
 * @package App\User
 */
interface AddressInterface
{
    public function getId(): string;
    public function getStreet(): string;
    public function getCity(): string;
    public function getCountry(): string;
    public function getHousenumber(): string;
    public function getPostcode(): string;
}
