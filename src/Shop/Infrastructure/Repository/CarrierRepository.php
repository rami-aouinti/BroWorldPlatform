<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Repository;

use App\General\Infrastructure\Repository\BaseRepository;
use App\Shop\Domain\Entity\Carrier;
use App\Shop\Domain\Repository\Interfaces\CarrierRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Carrier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carrier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carrier[]    findAll()
 * @method Carrier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarrierRepository extends BaseRepository implements CarrierRepositoryInterface
{
    /**
     * @psalm-var class-string
     */
    protected static string $entityName = Carrier::class;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(
        protected ManagerRegistry $managerRegistry,
    ) {
    }
}
