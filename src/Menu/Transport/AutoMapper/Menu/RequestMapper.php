<?php

declare(strict_types=1);

namespace App\Menu\Transport\AutoMapper\Menu;

use App\General\Transport\AutoMapper\RestRequestMapper;

/**
 * @package App\Menu
 */
class RequestMapper extends RestRequestMapper
{
    /**
     * @var array<int, non-empty-string>
     */
    protected static array $properties = [
        'title',
        'prefix',
        'link',
        'active',
        'action',
        'level',
    ];
}
