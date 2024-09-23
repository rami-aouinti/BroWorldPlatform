<?php

declare(strict_types=1);

namespace App\Shop\Transport\AutoMapper\Address;

use App\General\Transport\AutoMapper\RestAutoMapperConfiguration;
use App\Shop\Application\DTO\Address\AddressCreate;
use App\Shop\Application\DTO\Address\AddressPatch;
use App\Shop\Application\DTO\Address\AddressUpdate;

/**
 * @package App\Shop
 */
class AutoMapperConfiguration extends RestAutoMapperConfiguration
{
    /**
     * Classes to use specified request mapper.
     *
     * @var array<int, class-string>
     */
    protected static array $requestMapperClasses = [
        AddressCreate::class,
        AddressUpdate::class,
        AddressPatch::class,
    ];

    public function __construct(
        RequestMapper $requestMapper,
    ) {
        parent::__construct($requestMapper);
    }
}
