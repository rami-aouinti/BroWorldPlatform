<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Application\Service\Export\Renderer;

use App\Crm\Application\Service\Export\Base\CsvRenderer as BaseCsvRenderer;
use App\Crm\Application\Service\Export\RendererInterface;

final class CsvRenderer extends BaseCsvRenderer implements RendererInterface
{
    public function getIcon(): string
    {
        return 'csv';
    }

    public function getTitle(): string
    {
        return 'csv';
    }
}
