<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Application\Service\Widget\Type;

use App\Crm\Application\Service\Widget\WidgetException;
use App\Crm\Application\Service\Widget\WidgetInterface;
use App\Crm\Infrastructure\Repository\TimesheetRepository;

final class DurationWeek extends AbstractCounterDuration
{
    public function __construct(private TimesheetRepository $repository)
    {
    }

    /**
     * @param array<string, string|bool|int|null|array<string, mixed>> $options
     @return array<string, string|bool|int|null|array<string, mixed>>
     */
    public function getOptions(array $options = []): array
    {
        return array_merge(['color' => WidgetInterface::COLOR_WEEK], parent::getOptions($options));
    }

    public function getPermissions(): array
    {
        return ['view_other_timesheet'];
    }

    public function getId(): string
    {
        return 'DurationWeek';
    }

    public function getTitle(): string
    {
        return 'stats.durationWeek';
    }

    /**
     * @param array<string, string|bool|int|null|array<string, mixed>> $options
     */
    public function getData(array $options = []): mixed
    {
        try {
            return $this->repository->getDurationForTimeRange($this->createWeekStartDate(), $this->createWeekEndDate(), null);
        } catch (\Exception $ex) {
            throw new WidgetException(
                'Failed loading widget data: ' . $ex->getMessage()
            );
        }
    }
}
