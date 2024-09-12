<?php

declare(strict_types=1);

namespace App\User\Transport\Controller\Api\v1\Profile;

use App\Menu\Domain\Entity\Menu;
use App\User\Domain\Entity\User;
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
 * @package App\User
 */
#[AsController]
#[OA\Tag(name: 'Profile')]
class MenuController
{

    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * Get current user roles as an array, accessible only for 'IS_AUTHENTICATED_FULLY' users.
     */
    #[Route(
        path: '/v1/profile/menu',
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
    public function __invoke(User $loggedInUser): JsonResponse
    {

        return new JsonResponse(
            $this->serializer->serialize(
                $this->manageMenu($loggedInUser->getMenus()->toArray()),
                'json',
                [
                    'groups' => Menu::SET_USER_MENU,
                ],
            ),
            json: true,
        );
    }


    private function manageMenu(array $menuItems): array
    {
        $rootItems = [];

        foreach ($menuItems as $menuItem) {
            if ($menuItem->getParent() !== null) {
                continue;
            }

            $rootItems[$menuItem->getId()] = $this->formatMenuItem($menuItem);
        }

        return $rootItems;
    }

    /**
     * @param $menuItem
     *
     * @return array
     */
    private function formatMenuItem($menuItem): array
    {
        $children = $menuItem->getChildren();
        $subItems = [];

        foreach ($children as $child) {
            $subItems[$child->getId()] = $this->formatMenuItem($child);
        }

        return [
            'id' => $menuItem->getId(),
            'title' => $menuItem->getTitle(),
            'prefix' => $menuItem->getPrefix(),
            'link' => $menuItem->getLink(),
            'active' => $menuItem->isActive(),
            'action' => $menuItem->getAction(),
            'items' => $subItems
        ];
    }
}
