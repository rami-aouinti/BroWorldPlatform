<?php

declare(strict_types=1);

namespace App\Messenger\Transport\Controller\Api\v1\Message;

use App\General\Domain\Utils\JSON;
use App\Messenger\Domain\Entity\Message;
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
 * @package App\Message
 */
#[AsController]
#[OA\Tag(name: 'Message')]
class CreateMessageController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Get current user profile data, accessible only for 'IS_AUTHENTICATED_FULLY' users.
     *
     * @throws JsonException
     * @throws NotSupported
     */
    #[Route(
        path: '/v1/message/{receiver}',
        methods: [Request::METHOD_POST],
    )]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    #[OA\Response(
        response: 200,
        description: 'User profile data',
        content: new JsonContent(
            ref: new Model(
                type: Message::class,
                groups: [Message::SET_USER_MESSAGE],
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
        User $receiver,
        Request $request,
        HubInterface $hub
    ): JsonResponse
    {
        $data = $request->request->get('content');
        $message = new Message();
        $message->setSender($loggedInUser);
        $message->setReceiver($receiver);
        $message->setContent($data);
        $message->setSentAt(new DateTime());

        $this->entityManager->persist($message);
        $this->entityManager->flush();

        $update = new Update(
            '/chat/messages/' . $receiver->getUsername() . '/' . $loggedInUser->getUsername(),
            json_encode(['message' => $message->getContent()])
        );

        //dd($update);
        try {
            $hub->publish($update);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => 'Failed to send an update.',
                'code' => 0,
                'status' => 500,
                'debug' => [
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'message' => $e->getMessage(),
                ]
            ], 500);
        }


        /** @var array<string, string|array<string, string>> $output */
        $output = JSON::decode(
            $this->serializer->serialize(
                'message sent',
                'json',
                []
            ),
            true,
        );

        return new JsonResponse($output);
    }
}
