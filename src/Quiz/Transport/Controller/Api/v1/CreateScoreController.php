<?php

declare(strict_types=1);

namespace App\Quiz\Transport\Controller\Api\v1;

use App\Menu\Domain\Entity\Menu;
use App\Quiz\Domain\Entity\Quiz;
use App\Quiz\Domain\Entity\Score;
use App\Quiz\Infrastructure\Repository\QuizRepository;
use App\User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
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
 * @package App\Quiz
 */
#[AsController]
#[OA\Tag(name: 'Quiz')]
class CreateScoreController
{

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Get current user roles as an array, accessible only for 'IS_AUTHENTICATED_FULLY' users.
     */
    #[Route(
        path: '/v1/score/{quiz}/{score}',
        methods: [Request::METHOD_POST],
    )]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    public function __invoke(User $loggedInUser, Quiz $quiz, int $score): JsonResponse
    {
        $scoreItem = new Score();
        $scoreItem->setScore($score);
        $scoreItem->setUser($loggedInUser);
        $scoreItem->setQuiz($quiz);
        $this->entityManager->persist($scoreItem);
        $this->entityManager->flush();

        return new JsonResponse(
            $this->serializer->serialize(
                'Score saved',
                'json',
                [],
            ),
            json: true,
        );
    }
}
