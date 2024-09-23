<?php

declare(strict_types=1);

namespace App\Shop\Transport\AutoMapper\Carrier;

use App\General\Transport\AutoMapper\RestAutoMapperConfiguration;
use App\Shop\Application\DTO\Carrier\CarrierCreate;
use App\Shop\Application\DTO\Carrier\CarrierPatch;
use App\Shop\Application\DTO\Carrier\CarrierUpdate;

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
        CarrierCreate::class,
        CarrierUpdate::class,
        CarrierPatch::class,
    ];

    public function __construct(
        RequestMapper $requestMapper,
    ) {
        parent::__construct($requestMapper);
    }
}
