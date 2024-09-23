<?php

declare(strict_types=1);

namespace App\Shop\Transport\Controller\Api\v1\Carrier;

use App\General\Transport\Rest\Controller;
use App\General\Transport\Rest\ResponseHandler;
use App\General\Transport\Rest\Traits\Actions;
use App\Shop\Application\DTO\Carrier\CarrierCreate;
use App\Shop\Application\DTO\Carrier\CarrierPatch;
use App\Shop\Application\DTO\Carrier\CarrierUpdate;
use App\Shop\Application\Resource\CarrierResource;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @package App\Carrier
 *
 * @method CarrierResource getResource()
 * @method ResponseHandler getResponseHandler()
 */
#[AsController]
#[Route(
    path: '/v1/admin/shop/carrier',
)]
#[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
#[OA\Tag(name: 'Carrier Management')]
class CarrierController extends Controller
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
        Controller::METHOD_CREATE => CarrierCreate::class,
        Controller::METHOD_UPDATE => CarrierUpdate::class,
        Controller::METHOD_PATCH => CarrierPatch::class,
    ];

    public function __construct(
        CarrierResource $resource,
    ) {
        parent::__construct($resource);
    }
}
