<?php

declare(strict_types=1);

namespace App\Menu\Transport\Controller\Api\v1\Menu;

use App\General\Transport\Rest\Controller;
use App\General\Transport\Rest\ResponseHandler;
use App\General\Transport\Rest\Traits\Actions;
use App\Menu\Application\DTO\Menu\MenuCreate;
use App\Menu\Application\DTO\Menu\MenuPatch;
use App\Menu\Application\DTO\Menu\MenuUpdate;
use App\Menu\Application\Resource\MenuResource;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @package App\Menu
 *
 * @method MenuResource getResource()
 * @method ResponseHandler getResponseHandler()
 */
#[AsController]
#[Route(
    path: '/v1/menu',
)]
#[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
#[OA\Tag(name: 'Menu Management')]
class MenuController extends Controller
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
        Controller::METHOD_CREATE => MenuCreate::class,
        Controller::METHOD_UPDATE => MenuUpdate::class,
        Controller::METHOD_PATCH => MenuPatch::class,
    ];

    public function __construct(
        MenuResource $resource,
    ) {
        parent::__construct($resource);
    }
}
