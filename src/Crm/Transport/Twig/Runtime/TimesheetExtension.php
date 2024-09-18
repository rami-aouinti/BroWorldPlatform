<?php

declare(strict_types=1);

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Transport\Twig\Runtime;

use App\Crm\Application\Service\Model\FavoriteTimesheet;
use App\Crm\Application\Service\Timesheet\FavoriteRecordService;
use App\Crm\Domain\Entity\Timesheet;
use App\Crm\Infrastructure\Repository\TimesheetRepository;
use App\User\Domain\Entity\User;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * @package App\Crm\Transport\Twig\Runtime
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
final class TimesheetExtension implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly TimesheetRepository $repository,
        private readonly FavoriteRecordService $favoriteRecordService
    ) {
    }

    /**
     * @return array<Timesheet>
     */
    public function activeEntries(User $user, bool $ticktack = true): array
    {
        return $this->repository->getActiveEntries($user, $ticktack);
    }

    /**
     * @return array<FavoriteTimesheet>
     */
    public function favoriteEntries(User $user, int $limit = 5): array
    {
        return $this->favoriteRecordService->favoriteEntries($user, $limit);
    }
}
