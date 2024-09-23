<?php

declare(strict_types=1);

namespace App\Shop\Transport\Controller\Api\v1\Address;

use App\General\Transport\Rest\Controller;
use App\General\Transport\Rest\ResponseHandler;
use App\General\Transport\Rest\Traits\Actions;
use App\Shop\Application\DTO\Address\AddressCreate;
use App\Shop\Application\DTO\Address\AddressPatch;
use App\Shop\Application\DTO\Address\AddressUpdate;
use App\Shop\Application\Resource\AddressResource;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @package App\Address
 *
 * @method AddressResource getResource()
 * @method ResponseHandler getResponseHandler()
 */
#[AsController]
#[Route(
    path: '/v1/admin/shop/address',
)]
#[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
#[OA\Tag(name: 'Address Management')]
class AddressController extends Controller
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
        Controller::METHOD_CREATE => AddressCreate::class,
        Controller::METHOD_UPDATE => AddressUpdate::class,
        Controller::METHOD_PATCH => AddressPatch::class,
    ];

    public function __construct(
        AddressResource $resource,
    ) {
        parent::__construct($resource);
    }
}
