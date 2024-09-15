<?php

declare(strict_types=1);

namespace App\Blog\Transport\Controller\Api\v1\Post;

use App\Blog\Application\Resource\PostResource;
use App\Blog\Domain\Entity\Post;
use App\General\Transport\Rest\Controller;
use App\General\Transport\Rest\Traits\Methods;
use App\Role\Domain\Enum\Role;
use App\User\Application\Resource\UserResource;
use App\User\Domain\Entity\User;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Throwable;

/**
 * @package App\Post
 */
#[AsController]
#[OA\Tag(name: 'Post Management')]
class DeletePostController extends Controller
{
    use Methods\DeleteMethod;

    public function __construct(
        PostResource $resource,
    ) {
        parent::__construct($resource);
    }

    /**
     * Delete user entity, accessible only for 'ROLE_ROOT' users.
     *
     * @throws Throwable
     */
    #[Route(
        path: '/v1/post/{post}',
        requirements: [
            'post' => Requirement::UUID_V1,
        ],
        methods: [Request::METHOD_DELETE],
    )]
    #[IsGranted(Role::ROOT->value)]
    #[OA\Response(
        response: 200,
        description: 'deleted',
        content: new JsonContent(
            ref: new Model(type: Post::class, groups: ['Post']),
            type: 'object',
        ),
    )]
    #[OA\Response(
        response: 403,
        description: 'Access denied',
        content: new JsonContent(
            properties: [
                new Property(property: 'code', description: 'Error code', type: 'integer'),
                new Property(property: 'message', description: 'Error description', type: 'string'),
            ],
            type: 'object',
            example: [
                'code' => 403,
                'message' => 'Access denied',
            ],
        ),
    )]
    public function __invoke(Request $request, User $user, User $loggedInUser): Response
    {
        if ($loggedInUser === $user) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'You cannot remove yourself...');
        }

        return $this->deleteMethod($request, $user->getId());
    }
}
