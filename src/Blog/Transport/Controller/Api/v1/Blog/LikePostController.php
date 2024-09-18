<?php

declare(strict_types=1);

namespace App\Blog\Transport\Controller\Api\v1\Blog;

use App\Blog\Domain\Entity\Comment;
use App\Blog\Domain\Entity\Like;
use App\Blog\Domain\Entity\Post;
use App\Blog\Infrastructure\Repository\LikeRepository;
use App\Notification\Domain\Entity\Notification;
use App\User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\NotSupported;
use Exception;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @package App\Blog
 */
#[AsController]
#[OA\Tag(name: 'Blog')]
readonly class LikePostController
{

    public function __construct(
        private SerializerInterface $serializer,
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Get current user roles as an array, accessible only for 'IS_AUTHENTICATED_FULLY' users.
     *
     * @param Request $request
     * @param User    $loggedInUser
     * @param Post    $post
     *
     * @throws Exception
     * @return JsonResponse
     */
    #[Route(
        path: '/v1/post/{post}/like',
        methods: [Request::METHOD_POST],
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
    public function __invoke(Request $request, User $loggedInUser, Post $post): JsonResponse
    {
        $like = $this->entityManager->getRepository(Like::class)->findOneBy([
            'post' => $post,
            'user' => $loggedInUser
        ]);

        if ($like) {
            if ($this->entityManager->contains($like)) {
                $this->entityManager->remove($like);
                $this->entityManager->flush();
            } else {
                throw new Exception('Like entity is not managed by the EntityManager.');
            }

            return new JsonResponse(
                $this->serializer->serialize(
                    [
                        'likesCount' => $post->getLikesCount(),
                        'isLikedByUser' => false
                    ],
                    'json',
                    [],
                ),
                json: true,
            );
        }

        $newLike = new Like();
        $newLike->setPost($post);
        $newLike->setUser($loggedInUser);
        $notification = new Notification();
        $notification->setMessage($loggedInUser->getUsername() . ' likes your post');
        $notification->setUser($loggedInUser);
        $notification->setIsRead(false);
        $this->entityManager->persist($newLike);
        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        return new JsonResponse(
            $this->serializer->serialize(
                [
                    'likesCount' => $post->getLikesCount(),
                    'isLikedByUser' => true
                ],
                'json',
                [],
            ),
            json: true,
        );
    }
}
