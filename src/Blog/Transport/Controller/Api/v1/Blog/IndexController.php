<?php

declare(strict_types=1);

namespace App\Blog\Transport\Controller\Api\v1\Blog;

use App\Blog\Domain\Entity\Post;
use App\Blog\Infrastructure\Repository\PostRepository;
use App\Blog\Infrastructure\Repository\TagRepository;
use App\Menu\Domain\Entity\Menu;
use App\User\Domain\Entity\User;
use Doctrine\ORM\Exception\NotSupported;
use Exception;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @package App\Blog
 */
#[AsController]
#[OA\Tag(name: 'Blog')]
class IndexController
{

    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * Get current user roles as an array, accessible only for 'IS_AUTHENTICATED_FULLY' users.
     *
     * @throws NotSupported
     * @throws Exception
     */
    #[Route(
        path: '/v1/blog/post',
        defaults: ['page' => '1', '_format' => 'html'],
        methods: [Request::METHOD_GET],
    )]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    #[OA\Response(
        response: 200,
        description: 'List of logged in user user configurations',
        content: new JsonContent(
            type: 'array',
            items: new OA\Items(type: 'string', example: 'ROLE_USER'),
            example: ['ROLE_USER', 'ROLE_LOGGED'],
        ),
    )]
    #[OA\Response(
        response: 401,
        description: 'Invalid token (not found or expired)',
        content: new JsonContent(
            properties: [
                new Property(property: 'code', description: 'Error code', type: 'integer'),
                new Property(property: 'message', description: 'Error description', type: 'string'),
            ],
            type: 'object',
            example: [
                'code' => 401,
                'message' => 'JWT Token not found',
            ],
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
    #[Cache(smaxage: 10)]
    public function __invoke(
        Request $request,
        User $loggedInUser,
        int $page,
        PostRepository $postRepository,
        TagRepository $tagRepository
    ): JsonResponse
    {
        $tag = null;

        if ($request->query->has('tag')) {
            $tag = $tagRepository->findOneBy(['name' => $request->query->get('tag')]);
        }

        $posts = $postRepository->findLatest($page, $tag, $loggedInUser);

        $postsArray = $posts->getResults();
        foreach ($postsArray as &$postData) {
            $postData['post']['isLikedByUser'] = $postData[0]->isLikedByUser($loggedInUser);
            $postData['post']['likesCount'] = $postData[0]->getLikesCount();
            unset($postData['isLikedByUser'], $postData['likesCount']);
        }

        return new JsonResponse(
            $this->serializer->serialize(
                $postsArray,
                'json',
                [
                    'groups' => Post::SET_BLOG_POST,
                ],
            ),
            json: true,
        );
    }
}
