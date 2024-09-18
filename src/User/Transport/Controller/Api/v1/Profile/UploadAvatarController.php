<?php

declare(strict_types=1);

namespace App\User\Transport\Controller\Api\v1\Profile;

use App\General\Domain\Utils\JSON;
use App\Messenger\Domain\Entity\Message;
use App\User\Domain\Entity\Profile;
use App\User\Domain\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\NotSupported;
use JsonException;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Mercure\Update;

/**
 * @package App\Profile
 */
#[AsController]
#[OA\Tag(name: 'Profile')]
class UploadAvatarController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Get current user profile data, accessible only for 'IS_AUTHENTICATED_FULLY' users.
     *
     * @param User         $loggedInUser
     * @param User         $receiver
     * @param Request      $request
     * @param HubInterface $hub
     *
     * @throws JsonException
     * @return JsonResponse
     */
    #[Route(
        path: '/v1/profile/upload',
        methods: [Request::METHOD_POST],
    )]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    #[OA\Response(
        response: 200,
        description: 'User profile data',
        content: new JsonContent(
            ref: new Model(
                type: Profile::class,
                groups: [Profile::SET_PROFILE],
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
        Request $request
    ): JsonResponse
    {
        $file = $request->files->get('photo');

        if (!$file) {
            return new JsonResponse(['error' => 'No file uploaded'], 400);
        }
        $uploadDir = $this->getParameter('uploads_directory');
        try {

            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move($uploadDir, $filename);
            $loggedInUser->setAvatar($filename);
            $this->entityManager->persist($loggedInUser);
            $this->entityManager->flush();

            /** @var array<string, string|array<string, string>> $output */
            $output = JSON::decode(
            $this->serializer->serialize(
                'avatar uploaded',
                'json',
                []
            ),
            true,
        );

        return new JsonResponse($output);
        } catch (FileException $e) {
            return new JsonResponse(['error' => 'Failed to upload file'], 500);
        }
    }
}
