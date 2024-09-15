<?php

declare(strict_types=1);

namespace App\Blog\Domain\Repository\Interfaces;

use App\Blog\Application\Pagination\Paginator;
use App\Blog\Domain\Entity\Tag;
use App\User\Domain\Entity\User as Entity;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @package App\User
 */
interface PostRepositoryInterface
{
    public function findLatest(int $page = 1, ?Tag $tag = null): Paginator;

    public function findBySearchQuery(string $query, int $limit = Paginator::PAGE_SIZE): array;
}
