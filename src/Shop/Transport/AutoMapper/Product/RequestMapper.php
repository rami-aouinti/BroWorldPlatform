<?php

declare(strict_types=1);

namespace App\Shop\Transport\AutoMapper\Product;

use App\General\Domain\Enum\Language;
use App\General\Domain\Enum\Locale;
use App\General\Transport\AutoMapper\RestRequestMapper;
use InvalidArgumentException;
use Throwable;

use function array_map;

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
        'slug',
        'image',
        'subtitle',
        'description',
        'price',
        'isInHome'
    ];
}
