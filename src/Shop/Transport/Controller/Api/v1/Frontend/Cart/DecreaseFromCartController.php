<?php

declare(strict_types=1);

namespace App\Shop\Transport\Controller\Api\v1\Frontend\Cart;

use App\General\Domain\Utils\JSON;
use App\Media\Application\Service\MediaService;
use App\Media\Domain\Entity\MediaFolder;
use App\Media\Infrastructure\Repository\MediaFolderRepository;
use App\Notification\Application\Service\NotificationService;
use App\Notification\Domain\Entity\Notification;
use App\Shop\Domain\Entity\Category;
use App\Shop\Domain\Entity\Product;
use App\Shop\Infrastructure\Repository\CategoryRepository;
use App\User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\NotSupported;
use JsonException;
use League\Flysystem\FilesystemException;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
class DecreaseFromCartController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly EntityManagerInterface $entityManager,
        private readonly NotificationService $notificationService,
        private readonly MediaService $mediaService,
        private readonly CategoryRepository $categoryRepository,
        private readonly MediaFolderRepository $mediaFolderRepository,
        private readonly SluggerInterface $slugger
    ) {
    }

    /**
     * Get current user profile data, accessible only for 'IS_AUTHENTICATED_FULLY' users.
     *
     * @param User         $loggedInUser
     * @param Request      $request
     * @param HubInterface $hub
     *
     * @throws FilesystemException
     * @throws JsonException
     * @throws NotSupported
     * @return JsonResponse
     */
    #[Route(
        path: '/v1/shop/decrease/{product}/cart',
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
        Request $request,
        HubInterface $hub
    ): JsonResponse {

        $product = new Product();
        $product->setName($request->request->get('name'));
        $product->setSlug((string)$this->slugger->slug($request->request->get('name'))->lower());
        $product->setDescription($request->request->get('description'));
        $product->setPrice((float)$request->request->get('price'));
        $categoryRepo = $this->categoryRepository->findOneBy([
            'name' => $request->request->get('category')
        ]);
        if($categoryRepo) {
            $product->setCategory($categoryRepo);
        } else {
            $category = new Category();
            $category->setName($request->request->get('category'));
            $this->entityManager->persist($category);
            $product->setCategory($category);
        }

        $product->setSubtitle($request->request->get('subtitle'));
        $product->setIsInHome((bool)$request->request->get('isInHome'));

        $files = $request->files->all('files');
        if($files[0]) {
            $product->setImage($files[0]->getClientOriginalName());
        }

        foreach ($files as $file) {
            $folder = $this->createFolder('Products');
            $media = $this->mediaService->uploadMedia($file,'uploads/shop/products', $folder);
            $product->addMedia($media);
        }

        $this->entityManager->persist($product);
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

    private function createFolder(string $name, ?string $parentId = null): MediaFolder
    {
        $folder = new MediaFolder();
        $folder->setName($name);
        $folder->setParent($parentId);
        $this->mediaFolderRepository->save($folder);
        return $folder;
    }
}
