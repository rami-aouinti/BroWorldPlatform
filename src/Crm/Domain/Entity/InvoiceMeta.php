<?php

declare(strict_types=1);

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

use function get_class;

/**
 * @package App\Crm\Domain\Entity
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[ORM\Table(name: 'kimai2_invoices_meta')]
#[ORM\UniqueConstraint(columns: ['invoice_id', 'name'])]
/**
 * @package App\Crm
 */
#[ORM\Entity]
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
#[Serializer\ExclusionPolicy('all')]
class InvoiceMeta implements MetaTableTypeInterface
{
    use MetaTableTypeTrait;

    #[ORM\ManyToOne(targetEntity: Invoice::class, inversedBy: 'meta')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Assert\NotNull]
    private ?Invoice $invoice = null;

    public function setEntity(EntityWithMetaFields $entity): MetaTableTypeInterface
    {
        if (!($entity instanceof Invoice)) {
            throw new InvalidArgumentException(
                sprintf('Expected instanceof Invoice, received "%s"', get_class($entity))
            );
        }
        $this->invoice = $entity;

        return $this;
    }

    /**
     * @return Invoice|null
     */
    public function getEntity(): ?EntityWithMetaFields
    {
        return $this->invoice;
    }
}
