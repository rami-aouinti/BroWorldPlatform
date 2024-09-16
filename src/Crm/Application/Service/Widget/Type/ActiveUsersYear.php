<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Application\Service\Widget\Type;

use App\Crm\Application\Service\Configuration\SystemConfiguration;
use App\Crm\Application\Service\Widget\WidgetException;
use App\Crm\Application\Service\Widget\WidgetInterface;
use App\Crm\Infrastructure\Repository\TimesheetRepository;

final class ActiveUsersYear extends AbstractCounterYear
{
    public function __construct(private TimesheetRepository $repository, SystemConfiguration $systemConfiguration)
    {
        parent::__construct($systemConfiguration);
    }

    /**
     * @param array<string, string|bool|int|null|array<string, mixed>> $options
     @return array<string, string|bool|int|null|array<string, mixed>>
     */
    public function getOptions(array $options = []): array
    {
        return array_merge([
            'icon' => 'users',
            'color' => WidgetInterface::COLOR_YEAR,
        ], parent::getOptions($options));
    }

    /**
     * @param array<string, string|bool|int|null|array<string, mixed>> $options
     */
    protected function getYearData(\DateTimeInterface $begin, \DateTimeInterface $end, array $options = []): mixed
    {
        try {
            return $this->repository->countActiveUsers($begin, $end, null);
        } catch (\Exception $ex) {
            throw new WidgetException(
                'Failed loading widget data: ' . $ex->getMessage()
            );
        }
    }

    protected function getFinancialYearTitle(): string
    {
        return 'stats.activeUsersFinancialYear';
    }

    public function getPermissions(): array
    {
        return ['ROLE_TEAMLEAD'];
    }

    public function getId(): string
    {
        return 'activeUsersYear';
    }
}
