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

use App\Blog\Application\Pagination\Paginator;
use App\Blog\Domain\Entity\Post;
use App\Blog\Domain\Entity\Tag;
use App\Blog\Domain\Repository\Interfaces\PostRepositoryInterface;
use App\General\Infrastructure\Repository\BaseRepository;
use App\User\Domain\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

use function count;
use function Symfony\Component\String\u;

/**
 * @package App\Post
 *
 * @psalm-suppress LessSpecificImplementedReturnType
 * @codingStandardsIgnoreStart
 *
 * @method Post|null find(string $id, ?int $lockMode = null, ?int $lockVersion = null, ?string $entityManagerName = null)
 * @method Post|null findAdvanced(string $id, string | int | null $hydrationMode = null, string|null $entityManagerName = null)
 * @method Post|null findOneBy(array $criteria, ?array $orderBy = null, ?string $entityManagerName = null)
 * @method Post[] findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null, ?string $entityManagerName = null)
 * @method Post[] findByAdvanced(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null, ?array $search = null, ?string $entityManagerName = null)
 * @method Post[] findAll(?string $entityManagerName = null)
 *
 * @codingStandardsIgnoreEnd
 */
class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * @var array<int, string>
     */
    protected static array $searchColumns = ['title', 'slug', 'summary', 'content'];

    /**
     * @psalm-var class-string
     */
    protected static string $entityName = Post::class;

    public function __construct(
        protected ManagerRegistry $managerRegistry
    ) {
    }

    /**
     * @throws Exception
     */
    public function findLatest(int $page = 1, ?Tag $tag = null, ?User $currentUser = null): Paginator
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('a', 't')
            ->innerJoin('p.author', 'a')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.likes', 'l')
            ->where('p.publishedAt <= :now')
            ->orderBy('p.publishedAt', 'DESC')
            ->setParameter('now', new DateTimeImmutable());

        if ($tag !== null) {
            $qb->andWhere(':tag MEMBER OF p.tags')
                ->setParameter('tag', $tag);
        }

        if ($currentUser) {
            $qb->addSelect('COUNT(l.id) AS likesCount')
                ->addSelect('(CASE WHEN l.user = :currentUser THEN true ELSE false END) AS isLikedByUser')
                ->setParameter('currentUser', $currentUser);
        } else {
            $qb->addSelect('COUNT(l.id) AS likesCount')
                ->addSelect('false AS isLikedByUser');
        }

        $qb->groupBy('p.id, a.id, p.publishedAt, p.title, p.content, a.username');

        $qb->groupBy('p.id, a.id, p.publishedAt, p.title, p.content, a.username, t.id, t.name, l.user');

        return (new Paginator($qb))->paginate($page);
    }

    /**
     * @return Post[]
     */
    public function findBySearchQuery(string $query, int $limit = Paginator::PAGE_SIZE): array
    {
        $searchTerms = $this->extractSearchTerms($query);

        if (count($searchTerms) === 0) {
            return [];
        }

        $queryBuilder = $this->createQueryBuilder('p');

        foreach ($searchTerms as $key => $term) {
            $queryBuilder
                ->orWhere('p.title LIKE :t_' . $key)
                ->setParameter('t_' . $key, '%' . $term . '%')
            ;
        }

        /** @var Post[] $result */
        $result = $queryBuilder
            ->orderBy('p.publishedAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;

        return $result;
    }

    /**
     * Transforms the search string into an array of search terms.
     *
     * @return string[]
     */
    private function extractSearchTerms(string $searchQuery): array
    {
        $terms = array_unique(u($searchQuery)->replaceMatches('/[[:space:]]+/', ' ')->trim()->split(' '));

        // ignore the search terms that are too short
        return array_filter($terms, static function ($term) {
            return $term->length() >= 2;
        });
    }
}
