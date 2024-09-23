<?php

declare(strict_types=1);

namespace App\Shop\Transport\Controller\Api\v1\Order;

use App\General\Transport\Rest\Controller;
use App\General\Transport\Rest\ResponseHandler;
use App\General\Transport\Rest\Traits\Actions;
use App\Shop\Application\DTO\Order\OrderCreate;
use App\Shop\Application\DTO\Order\OrderPatch;
use App\Shop\Application\DTO\Order\OrderUpdate;
use App\Shop\Application\Resource\OrderResource;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @package App\Order
 *
 * @method OrderResource getResource()
 * @method ResponseHandler getResponseHandler()
 */
#[AsController]
#[Route(
    path: '/v1/admin/shop/order',
)]
#[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
#[OA\Tag(name: 'Order Management')]
class OrderController extends Controller
{
    use Actions\Admin\CountAction;
    use Actions\Admin\FindAction;
    use Actions\Admin\FindOneAction;
    use Actions\Admin\IdsAction;
    use Actions\Root\CreateAction;
    use Actions\Root\PatchAction;
    use Actions\Root\UpdateAction;

    /**
     * @var array<string, string>
     */
    protected static array $dtoClasses = [
        Controller::METHOD_CREATE => OrderCreate::class,
        Controller::METHOD_UPDATE => OrderUpdate::class,
        Controller::METHOD_PATCH => OrderPatch::class,
    ];

    public function __construct(
        OrderResource $resource,
    ) {
        parent::__construct($resource);
    }
}
