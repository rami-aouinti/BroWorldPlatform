<?php

declare(strict_types=1);

namespace App\Messenger\Transport\Controller\Api\v1\Message;

use App\General\Domain\Utils\JSON;
use App\Messenger\Domain\Entity\Message;
use App\Messenger\Infrastructure\Repository\MessageRepository;
use App\User\Domain\Entity\User;
use DateInterval;
use DateTime;
use Doctrine\ORM\Exception\NotSupported;
use JsonException;
use Nelmio\ApiDocBundle\Annotation\Model;
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
 * @package App\Message
 */
#[AsController]
#[OA\Tag(name: 'Message')]
class IndexController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
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
        methods: [Request::METHOD_GET],
    )]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    #[OA\Response(
        response: 200,
        description: 'User profile data',
        content: new JsonContent(
            ref: new Model(
                type: Message::class,
                groups: ['set.UserMessage'],
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
    public function __invoke(User $loggedInUser, User $receiver, MessageRepository $messageRepository): JsonResponse
    {
        $messagesSentByUserToUser = $messageRepository->findBy([
            'sender' => $loggedInUser,
            'receiver' => $receiver,
        ]);

        $messagesSentByUserToUserReverse = $messageRepository->findBy([
            'sender' => $receiver,
            'receiver' => $loggedInUser,
        ]);

        $allMessages = array_merge($messagesSentByUserToUser, $messagesSentByUserToUserReverse);
        $messages = [];
        $listUserConversations = [];

        foreach ($allMessages as $key => $message) {
            $messages[$key]['id'] = $message->getId();
            $messages[$key]['userId'] = $message->getReceiver()->getId();
            $messages[$key]['name'] = $message->getSender()->getUsername();
            $messages[$key]['time'] = $this->getMessageDate($message->getSentAt());
            $messages[$key]['message'] = $message->getContent();
            if ($message->getSender()->getId() === $loggedInUser->getId()) {
                $messages[$key]['type'] = 'sent';
            } else {
                $messages[$key]['type'] = 'received';
                $listUserConversations[$message->getReceiver()->getId()]['id'] = $message->getId();
                $listUserConversations[$message->getReceiver()->getId()]['userId'] = $message->getSender()->getId();
                $listUserConversations[$message->getReceiver()->getId()]['image'] = '/img/team-5.66b80bb3.jpg';
                $listUserConversations[$message->getReceiver()->getId()]['name'] = $message->getSender()->getUsername();
                $listUserConversations[$message->getReceiver()->getId()]['time'] = $this->getMessageDate($message->getSentAt());
                $listUserConversations[$message->getReceiver()->getId()]['message'] = $message->getContent();
            }
        }
        /** @var array<string, string|array<string, string>> $output */
        $output = JSON::decode(
            $this->serializer->serialize(
                [
                    'messages' => $messages,
                    'listUserConversations' => $listUserConversations,
                ],
                'json',
                [
                    'groups' => User::SET_USER_PROFILE,
                ]
            ),
            true,
        );

        return new JsonResponse($output);
    }

    private function getMessageDate($date): string
    {
        $now = new DateTime();
        $interval = $now->diff($date);

        if ($date->format('Y-m-d') === $now->format('Y-m-d')) {
            $formattedDate = $date->format('g:i a'); // Format comme '4:42 pm'
        } elseif ($date->format('Y-m-d') === $now->sub(new DateInterval('P1D'))->format('Y-m-d')) {
            $formattedDate = 'yesterday';
        } elseif ($interval->days <= 7) {
            $formattedDate = 'that one week';
        } else {
            $formattedDate = $date->format('F j, Y'); // Format par défaut
        }

        return $formattedDate;
    }
}
