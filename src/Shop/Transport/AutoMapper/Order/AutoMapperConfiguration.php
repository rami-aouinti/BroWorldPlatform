<?php

declare(strict_types=1);

namespace App\Shop\Transport\AutoMapper\Order;

use App\General\Transport\AutoMapper\RestAutoMapperConfiguration;
use App\Shop\Application\DTO\Order\OrderCreate;
use App\Shop\Application\DTO\Order\OrderPatch;
use App\Shop\Application\DTO\Order\OrderUpdate;

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
        OrderCreate::class,
        OrderUpdate::class,
        OrderPatch::class,
    ];

    public function __construct(
        RequestMapper $requestMapper,
    ) {
        parent::__construct($requestMapper);
    }
}
