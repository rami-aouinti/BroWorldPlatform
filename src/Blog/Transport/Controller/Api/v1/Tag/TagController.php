<?php

declare(strict_types=1);

namespace App\Blog\Transport\Controller\Api\v1\Tag;

use App\Blog\Application\DTO\Tag\TagCreate;
use App\Blog\Application\DTO\Tag\TagPatch;
use App\Blog\Application\DTO\Tag\TagUpdate;
use App\Blog\Application\Resource\TagResource;
use App\General\Transport\Rest\Controller;
use App\General\Transport\Rest\ResponseHandler;
use App\General\Transport\Rest\Traits\Actions;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @package App\Tag
 *
 * @method TagResource getResource()
 * @method ResponseHandler getResponseHandler()
 */
#[AsController]
#[Route(
    path: '/v1/tag',
)]
#[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
#[OA\Tag(name: 'Tag Management')]
class TagController extends Controller
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
        Controller::METHOD_CREATE => TagCreate::class,
        Controller::METHOD_UPDATE => TagUpdate::class,
        Controller::METHOD_PATCH => TagPatch::class,
    ];

    public function __construct(
        TagResource $resource,
    ) {
        parent::__construct($resource);
    }
}
