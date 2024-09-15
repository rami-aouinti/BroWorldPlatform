<?php

declare(strict_types=1);

namespace App\Calendar\Infrastructure\Repository;

use App\Calendar\Domain\Entity\Event;
use Doctrine\Persistence\ManagerRegistry;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class QuizRepository
 *
 * @package App\Quiz\Infrastructure\Repository
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }
}
