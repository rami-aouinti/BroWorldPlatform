<?php

declare(strict_types=1);

namespace App\Shop\Transport\Controller\Api\v1\Product;

use App\General\Transport\Rest\Controller;
use App\General\Transport\Rest\ResponseHandler;
use App\General\Transport\Rest\Traits\Actions;
use App\Shop\Application\DTO\Product\ProductCreate;
use App\Shop\Application\DTO\Product\ProductPatch;
use App\Shop\Application\DTO\Product\ProductUpdate;
use App\Shop\Application\Resource\ProductResource;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @package App\Product
 *
 * @method ProductResource getResource()
 * @method ResponseHandler getResponseHandler()
 */
#[AsController]
#[Route(
    path: '/v1/admin/shop/product',
)]
#[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
#[OA\Tag(name: 'Product Management')]
class ProductController extends Controller
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
        Controller::METHOD_CREATE => ProductCreate::class,
        Controller::METHOD_UPDATE => ProductUpdate::class,
        Controller::METHOD_PATCH => ProductPatch::class,
    ];

    public function __construct(
        ProductResource $resource,
    ) {
        parent::__construct($resource);
    }
}
