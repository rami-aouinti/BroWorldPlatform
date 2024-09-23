<?php

declare(strict_types=1);

namespace App\Shop\Transport\Controller\Api\v1\Frontend\Cart;

use App\Shop\Domain\Entity\Product;
use App\Shop\Domain\Model\Cart;
use App\Shop\Infrastructure\Repository\CartRepository;
use App\Shop\Infrastructure\Repository\ProductRepository;
use App\User\Domain\Entity\User;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;
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
 * @package App\Shop
 */
#[AsController]
#[OA\Tag(name: 'Shop')]
readonly class GetCartController
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * Get current user roles as an array, accessible only for 'IS_AUTHENTICATED_FULLY' users.
     *
     * @param ProductRepository $productRepository
     * @param User              $loggedInUser
     *
     * @return JsonResponse
     */
    #[Route(
        path: '/v1/shop/cart',
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
    public function __invoke(User $loggedInUser, CartRepository $cartRepository): JsonResponse
    {
        $cart = $cartRepository->findOneBy([
            'user' => $loggedInUser
        ]);

        $cartProducts = $cart->getCartItems();

        return new JsonResponse(
            $this->serializer->serialize(
                $cartProducts,
                'json',
                [
                    'groups' => Product::SET_SHOP_PRODUCT,
                ],
            ),
            json: true,
        );
    }
}
