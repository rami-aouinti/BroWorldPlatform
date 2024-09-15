<?php

declare(strict_types=1);

namespace App\Messenger\Infrastructure\Repository;

use App\General\Infrastructure\Repository\BaseRepository;
use App\Messenger\Domain\Entity\Message as Entity;
use App\Messenger\Domain\Repository\Interfaces\MessageRepositoryInterface;
use App\User\Domain\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @package App\Configuration
 *
 * @psalm-suppress LessSpecificImplementedReturnType
 * @codingStandardsIgnoreStart
 *
 * @method Entity|null find(string $id, ?int $lockMode = null, ?int $lockVersion = null, ?string $entityManagerName = null)
 * @method Entity|null findAdvanced(string $id, string | int | null $hydrationMode = null, string|null $entityManagerName = null)
 * @method Entity|null findOneBy(array $criteria, ?array $orderBy = null, ?string $entityManagerName = null)
 * @method Entity[] findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null, ?string $entityManagerName = null)
 * @method Entity[] findByAdvanced(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null, ?array $search = null, ?string $entityManagerName = null)
 * @method Entity[] findAll(?string $entityManagerName = null)
 *
 * @codingStandardsIgnoreEnd
 */
class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{
    /**
     * @var array<int, string>
     */
    protected static array $searchColumns = ['content'];

    /**
     * @psalm-var class-string
     */
    protected static string $entityName = Entity::class;

    public function __construct(
        protected ManagerRegistry $managerRegistry) {
    }

    /**
     * @param User $sender
     * @param User $receiver
     *
     * @return float|int|mixed|string
     */
    public function findByUsers(User $sender, User $receiver): mixed
    {

        return $this->createQueryBuilder('m')
            ->where('(m.sender = :sender AND m.receiver = :receiver) OR (m.sender = :receiver AND m.receiver = :sender)')
            ->setParameter('sender', $sender)
            ->setParameter('receiver', $receiver)
            ->orderBy('m.sentAt', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
