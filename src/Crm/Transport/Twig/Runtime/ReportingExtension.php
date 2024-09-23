<?php

declare(strict_types=1);

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Transport\Twig\Runtime;

use App\Crm\Application\Service\Reporting\ReportingService;
use App\Crm\Application\Service\Reporting\ReportInterface;
use App\User\Domain\Entity\User;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * @package App\Crm\Transport\Twig\Runtime
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
final class ReportingExtension implements RuntimeExtensionInterface
{
    public function __construct(
        private ReportingService $service
    ) {
    }

    /**
     * @return ReportInterface[]
     */
    public function getAvailableReports(User $user): array
    {
        return $this->service->getAvailableReports($user);
    }
}
