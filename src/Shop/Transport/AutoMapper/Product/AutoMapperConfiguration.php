<?php

declare(strict_types=1);

namespace App\Shop\Transport\AutoMapper\Product;

use App\General\Transport\AutoMapper\RestAutoMapperConfiguration;
use App\Shop\Application\DTO\Product\ProductCreate;
use App\Shop\Application\DTO\Product\ProductPatch;
use App\Shop\Application\DTO\Product\ProductUpdate;

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
        ProductCreate::class,
        ProductUpdate::class,
        ProductPatch::class,
    ];

    public function __construct(
        RequestMapper $requestMapper,
    ) {
        parent::__construct($requestMapper);
    }
}
