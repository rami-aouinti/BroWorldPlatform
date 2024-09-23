<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Application\Service\Export\Timesheet;

use App\Crm\Application\Service\Export\Base\HtmlRenderer as BaseHtmlRenderer;
use App\Crm\Application\Service\Export\TimesheetExportInterface;

final class HtmlRenderer extends BaseHtmlRenderer implements TimesheetExportInterface
{
    public function getId(): string
    {
        return 'print';
    }
    protected function getTemplate(): string
    {
        return 'timesheet/export.html.twig';
    }
}
