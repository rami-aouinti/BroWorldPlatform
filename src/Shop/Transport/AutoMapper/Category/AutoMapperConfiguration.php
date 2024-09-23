<?php

declare(strict_types=1);

namespace App\Shop\Transport\AutoMapper\Category;

use App\General\Transport\AutoMapper\RestAutoMapperConfiguration;
use App\Shop\Application\DTO\Category\CategoryCreate;
use App\Shop\Application\DTO\Category\CategoryPatch;
use App\Shop\Application\DTO\Category\CategoryUpdate;

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
        CategoryCreate::class,
        CategoryUpdate::class,
        CategoryPatch::class,
    ];

    public function __construct(
        RequestMapper $requestMapper,
    ) {
        parent::__construct($requestMapper);
    }
}
