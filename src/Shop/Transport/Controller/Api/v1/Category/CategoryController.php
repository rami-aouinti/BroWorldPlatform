<?php

declare(strict_types=1);

namespace App\Shop\Transport\Controller\Api\v1\Category;

use App\General\Transport\Rest\Controller;
use App\General\Transport\Rest\ResponseHandler;
use App\General\Transport\Rest\Traits\Actions;
use App\Shop\Application\DTO\Category\CategoryCreate;
use App\Shop\Application\DTO\Category\CategoryPatch;
use App\Shop\Application\DTO\Category\CategoryUpdate;
use App\Shop\Application\Resource\CategoryResource;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @package App\Category
 *
 * @method CategoryResource getResource()
 * @method ResponseHandler getResponseHandler()
 */
#[AsController]
#[Route(
    path: '/v1/admin/shop/category',
)]
#[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
#[OA\Tag(name: 'Category Management')]
class CategoryController extends Controller
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
        Controller::METHOD_CREATE => CategoryCreate::class,
        Controller::METHOD_UPDATE => CategoryUpdate::class,
        Controller::METHOD_PATCH => CategoryPatch::class,
    ];

    public function __construct(
        CategoryResource $resource,
    ) {
        parent::__construct($resource);
    }
}
