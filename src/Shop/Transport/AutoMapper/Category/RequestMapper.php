<?php

declare(strict_types=1);

namespace App\Shop\Transport\AutoMapper\Category;

use App\General\Transport\AutoMapper\RestRequestMapper;

/**
 * @package App\Shop
 */
class RequestMapper extends RestRequestMapper
{
    /**
     * @var array<int, non-empty-string>
     */
    protected static array $properties = [
        'name',
    ];
}
