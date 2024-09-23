<?php

declare(strict_types=1);

namespace App\Blog\Transport\AutoMapper\Tag;

use App\General\Transport\AutoMapper\RestRequestMapper;

/**
 * @package App\Configuration
 */
class RequestMapper extends RestRequestMapper
{
    /**
     * @var array<int, non-empty-string>
     */
    protected static array $properties = [
        'configurationKey',
        'configurationEntry',
    ];
}
