<?php

declare(strict_types=1);

namespace App\Menu\Transport\AutoMapper\Menu;

use App\General\Transport\AutoMapper\RestAutoMapperConfiguration;
use App\Menu\Application\DTO\Menu\MenuCreate;
use App\Menu\Application\DTO\Menu\MenuPatch;
use App\Menu\Application\DTO\Menu\MenuUpdate;

/**
 * @package App\Menu
 */
class AutoMapperConfiguration extends RestAutoMapperConfiguration
{
    /**
     * Classes to use specified request mapper.
     *
     * @var array<int, class-string>
     */
    protected static array $requestMapperClasses = [
        MenuCreate::class,
        MenuUpdate::class,
        MenuPatch::class,
    ];

    public function __construct(
        RequestMapper $requestMapper,
    ) {
        parent::__construct($requestMapper);
    }
}
