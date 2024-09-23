<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Repository;

use App\General\Infrastructure\Repository\BaseRepository;
use App\Shop\Domain\Entity\Order;
use App\Shop\Domain\Repository\Interfaces\OrderRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    /**
     * @psalm-var class-string
     */
    protected static string $entityName = Order::class;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(
        protected ManagerRegistry $managerRegistry,
    ) {
    }
    /**
    * @return Order[] Returns an array of Order objects
    */
    public function findPaidOrdersByUser($user)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.state > :val')
            ->andWhere('o.user = :user')
            ->setParameter('val', 0)
            ->setParameter('user', $user)
            ->orderBy('o.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


}
