<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Blog\Infrastructure\Repository;

use App\Blog\Domain\Entity\Like;
use App\General\Infrastructure\Repository\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @package App\Like
 *
 * @psalm-suppress LessSpecificImplementedReturnType
 * @codingStandardsIgnoreStart
 *
 * @method Like|null find(string $id, ?int $lockMode = null, ?int $lockVersion = null, ?string $entityManagerName = null)
 * @method Like|null findAdvanced(string $id, string | int | null $hydrationMode = null, string|null $entityManagerName = null)
 * @method Like|null findOneBy(array $criteria, ?array $orderBy = null, ?string $entityManagerName = null)
 * @method Like[] findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null, ?string $entityManagerName = null)
 * @method Like[] findByAdvanced(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null, ?array $search = null, ?string $entityManagerName = null)
 * @method Like[] findAll(?string $entityManagerName = null)
 *
 * @codingStandardsIgnoreEnd
 */
class LikeRepository extends BaseRepository
{
    /**
     * @var array<int, string>
     */
    protected static array $searchColumns = ['title', 'slug', 'summary', 'content'];

    /**
     * @psalm-var class-string
     */
    protected static string $entityName = Like::class;

    public function __construct(
        protected ManagerRegistry $managerRegistry
    ) {
    }
}
