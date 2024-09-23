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

use App\Blog\Domain\Entity\Tag;
use App\Blog\Domain\Repository\Interfaces\TagRepositoryInterface;
use App\General\Infrastructure\Repository\BaseRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * This custom Doctrine repository is empty because so far we don't need any custom
 * method to query for application user information. But it's always a good practice
 * to define a custom repository that will be used when the application grows.
 *
 * See https://symfony.com/doc/current/doctrine.html#querying-for-objects-the-repository
 *
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 *
 * @template-extends ServiceEntityRepository<Tag>
 */
class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    /**
     * @var array<int, string>
     */
    protected static array $searchColumns = ['name'];

    /**
     * @psalm-var class-string
     */
    protected static string $entityName = Tag::class;

    public function __construct(
        protected ManagerRegistry $managerRegistry
    ) {
    }
}
