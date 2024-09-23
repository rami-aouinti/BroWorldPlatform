<?php

declare(strict_types=1);

namespace App\Blog\Transport\AutoMapper\Tag;

use App\Blog\Application\DTO\Tag\TagCreate;
use App\Blog\Application\DTO\Tag\TagPatch;
use App\Blog\Application\DTO\Tag\TagUpdate;
use App\General\Transport\AutoMapper\RestAutoMapperConfiguration;

/**
 * @package App\Tag
 */
class AutoMapperConfiguration extends RestAutoMapperConfiguration
{
    /**
     * Classes to use specified request mapper.
     *
     * @var array<int, class-string>
     */
    protected static array $requestMapperClasses = [
        TagCreate::class,
        TagUpdate::class,
        TagPatch::class,
    ];

    public function __construct(
        RequestMapper $requestMapper,
    ) {
        parent::__construct($requestMapper);
    }
}
