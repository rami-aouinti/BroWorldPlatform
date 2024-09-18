<?php

declare(strict_types=1);

namespace App\Blog\Transport\AutoMapper\Comment;

use App\Blog\Application\DTO\Comment\CommentCreate;
use App\Blog\Application\DTO\Comment\CommentPatch;
use App\Blog\Application\DTO\Comment\CommentUpdate;
use App\General\Transport\AutoMapper\RestAutoMapperConfiguration;

/**
 * @package App\Comment
 */
class AutoMapperConfiguration extends RestAutoMapperConfiguration
{
    /**
     * Classes to use specified request mapper.
     *
     * @var array<int, class-string>
     */
    protected static array $requestMapperClasses = [
        CommentCreate::class,
        CommentUpdate::class,
        CommentPatch::class,
    ];

    public function __construct(
        RequestMapper $requestMapper,
    ) {
        parent::__construct($requestMapper);
    }
}
