<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Repository;

use App\General\Infrastructure\Repository\BaseRepository;
use App\Shop\Domain\Entity\Product;
use App\Shop\Domain\Model\Search;
use App\Shop\Domain\Repository\Interfaces\ProductRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * @psalm-var class-string
     */
    protected static string $entityName = Product::class;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(
        protected ManagerRegistry $managerRegistry,
    ) {
    }

    /**
     *
     * @return Product[] Returns an array of Product objects
     */
    public function findWithSearch(Search $search): array
    {
        $query = $this->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.category', 'c')
        ;
        if (!empty($search->getCategories())) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->getCategories())
            ;
        }

        if (!empty($search->getString())) {
            $query = $query
                ->andWhere('p.name LIKE :string')
                ->setParameter('string', "%{$search->getString()}%")
            ;
        }

        return $query->getQuery()->getResult();

    }

}
