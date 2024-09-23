<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Application\Service\Invoice;

use App\Crm\Domain\Entity\ExportableItem;
use App\Crm\Infrastructure\Repository\Query\InvoiceQuery;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag]
interface InvoiceItemRepositoryInterface
{
    /**
     * @param ExportableItem[] $invoiceItems
     */
    public function setExported(array $invoiceItems) /* : void */;

    /**
     * @return ExportableItem[]
     */
    public function getInvoiceItemsForQuery(InvoiceQuery $query): iterable;
}
