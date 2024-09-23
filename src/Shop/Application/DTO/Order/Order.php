<?php

declare(strict_types=1);

namespace App\Shop\Application\DTO\Order;

use App\General\Application\DTO\Interfaces\RestDtoInterface;
use App\General\Application\DTO\RestDto;
use App\General\Application\Validator\Constraints as GeneralAppAssert;
use App\General\Domain\Entity\Interfaces\EntityInterface;
use App\General\Domain\Enum\Language;
use App\General\Domain\Enum\Locale;
use App\Tool\Application\Validator\Constraints as ToolAppAssert;
use App\Tool\Domain\Service\Interfaces\LocalizationServiceInterface;
use App\Shop\Domain\Entity\Order as Entity;
use Symfony\Component\Validator\Constraints as Assert;

use function array_map;

/**
 * @package App\Order
 *
 * @method self|RestDtoInterface get(string $id)
 * @method self|RestDtoInterface patch(RestDtoInterface $dto)
 * @method Entity|EntityInterface update(EntityInterface $entity)
 */
class Order extends RestDto
{
    private ?string $carrierName;

    private ?string $carrierPrice;

    private ?string $delivery;

    private ?string $reference;

    private ?string $stripeSession;

    private ?int $state;

    public function getCarrierName(): ?string
    {
        return $this->carrierName;
    }

    public function setCarrierName(string $carrierName): self
    {
        $this->setVisited('carrierName');

        $this->carrierName = $carrierName;

        return $this;
    }

    public function getCarrierPrice(): ?string
    {
        return $this->carrierPrice;
    }

    public function setCarrierPrice(string $carrierPrice): self
    {
        $this->setVisited('carrierPrice');

        $this->carrierPrice = $carrierPrice;

        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(string $delivery): self
    {
        $this->setVisited('delivery');

        $this->delivery = $delivery;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->setVisited('reference');

        $this->reference = $reference;

        return $this;
    }

    public function getStripeSession(): ?string
    {
        return $this->stripeSession;
    }

    public function setStripeSession(?string $stripeSession): self
    {
        $this->setVisited('stripeSession');

        $this->stripeSession = $stripeSession;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->setVisited('state');

        $this->state = $state;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param EntityInterface|Entity $entity
     */
    public function load(EntityInterface $entity): self
    {
        if ($entity instanceof Entity) {
            $this->id = $entity->getId();
            $this->carrierName = $entity->getCarrierName();
            $this->carrierPrice = $entity->getCarrierPrice();
            $this->delivery = $entity->getDelivery();
            $this->reference = $entity->getReference();
            $this->stripeSession = $entity->getStripeSession();
            $this->state = $entity->getState();
        }

        return $this;
    }
}
