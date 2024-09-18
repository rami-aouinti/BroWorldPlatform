<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Application\Service\Export;

use App\Crm\Domain\Entity\Timesheet;
use App\Crm\Infrastructure\Repository\Query\TimesheetQuery;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpFoundation\Response;

#[AutoconfigureTag]
interface TimesheetExportInterface
{
    /**
     * @param Timesheet[] $timesheets
     */
    public function render(array $timesheets, TimesheetQuery $query): Response;

    public function getId(): string;
}
