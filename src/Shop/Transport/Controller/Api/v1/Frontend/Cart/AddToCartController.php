<?php

declare(strict_types=1);

namespace App\Shop\Transport\Controller\Api\v1\Frontend\Cart;

use App\General\Domain\Utils\JSON;
use App\Media\Application\Service\MediaService;
use App\Media\Domain\Entity\MediaFolder;
use App\Media\Infrastructure\Repository\MediaFolderRepository;
use App\Notification\Application\Service\NotificationService;
use App\Notification\Domain\Entity\Notification;
use App\Shop\Domain\Entity\Product;
use App\Shop\Domain\Entity\Cart;
use App\Shop\Infrastructure\Repository\CartRepository;
use App\Shop\Infrastructure\Repository\CategoryRepository;
use App\Shop\Infrastructure\Repository\ProductRepository;
use App\User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\NotSupported;
use JsonException;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @package App\Shop
 */
#[AsController]
#[OA\Tag(name: 'Shop')]
class AddToCartController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly EntityManagerInterface $entityManager,
        private readonly NotificationService $notificationService,
        private readonly MediaFolderRepository $mediaFolderRepository,
    ) {
    }

    /**
     * Get current user profile data, accessible only for 'IS_AUTHENTICATED_FULLY' users.
     *
     * @param User              $loggedInUser
     * @param Product           $product
     * @param Request           $request
     * @param HubInterface      $hub
     * @param ProductRepository $productRepository
     * @param CartRepository    $cartRepository
     *
     * @throws JsonException
     * @return JsonResponse
     */
    #[Route(
        path: '/v1/shop/add/{product}/cart',
        methods: [Request::METHOD_POST],
    )]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    #[OA\Response(
        response: 200,
        description: 'User profile data',
        content: new JsonContent(
            ref: new Model(
                type: Product::class,
                groups: [Product::SET_SHOP_PRODUCT],
            ),
            type: 'object',
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
    public function __invoke(
        User $loggedInUser,
        Product $product,
        Request $request,
        HubInterface $hub,
        ProductRepository $productRepository,
        CartRepository $cartRepository
    ): JsonResponse {

        $cart = $cartRepository->findOneBy([
            'user' => $loggedInUser
        ]);

        if(!$cart) {
            $cart = new Cart();
            $cart->setUser($loggedInUser);
            $cart->addCartItem($product, 1);
        } else {
            $cartItems = $cart->getCartItems();
            $productInCart = null;
            foreach ($cartItems as $cartItem) {
                if($cartItem->getProduct()->getId() === $product->getId()) {
                    $productInCart = $cartItem;
                }
            }

            if($productInCart) {
                $productInCart->setQuantity($productInCart->getQuantity() + 1);
            } else {
                $cart->addCartItem($product, 1);
            }
        }

        $cart->setQuantity(1);
        $cartRepository->save($cart);

        $notification = new Notification();
        $notification->setUser($loggedInUser);
        $notification->setMessage('New Product was added');
        $notification->setIsRead(false);

        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        $this->notificationService->sendNotification($loggedInUser, $notification);

        /** @var array<string, string|array<string, string>> $output */
        $output = JSON::decode(
            $this->serializer->serialize(
                'product created',
                'json',
                []
            ),
            true,
        );

        return new JsonResponse($output);
    }
}
