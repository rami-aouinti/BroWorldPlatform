<?php

declare(strict_types=1);

namespace App\Quiz\Infrastructure\Repository;

use App\Quiz\Domain\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @package App\Quiz\Infrastructure\Repository
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
class QuizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    /**
     * @return float|int|mixed|string
     */
    public function findByFilters(?string $categoryName, ?string $difficultyLevel): mixed
    {
        $qb = $this->createQueryBuilder('q')
            ->leftJoin('q.category', 'c')
            ->leftJoin('q.difficulty', 'd');

        if ($categoryName) {
            $qb->andWhere('c.name = :category')
                ->setParameter('category', $categoryName);
        }

        if ($difficultyLevel) {
            $qb->andWhere('d.level = :difficulty')
                ->setParameter('difficulty', $difficultyLevel);
        }

        return $qb->getQuery()->getResult();
    }
}
