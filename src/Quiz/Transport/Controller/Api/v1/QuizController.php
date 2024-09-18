<?php

declare(strict_types=1);

namespace App\Quiz\Transport\Controller\Api\v1;

use App\Menu\Domain\Entity\Menu;
use App\Quiz\Infrastructure\Repository\QuizRepository;
use App\User\Domain\Entity\User;
use OpenApi\Attributes as OA;
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
class QuizController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * Get current user roles as an array, accessible only for 'IS_AUTHENTICATED_FULLY' users.
     */
    #[Route(
        path: '/v1/quiz/{category}/{difficulty}',
        methods: [Request::METHOD_GET],
    )]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    public function __invoke(User $loggedInUser, string $category, string $difficulty, QuizRepository $quizRepository): JsonResponse
    {
        $quizzes = $quizRepository->findByFilters($category, $difficulty);
        $quizIndex = array_rand($quizzes);
        $randomQuiz = $quizzes[$quizIndex];
        $questions = $randomQuiz->getQuestions();
        $data = [];
        foreach ($questions as $question) {
            $newArray[] = $question->getCorrectAnswer();
            $data[] = [
                'quiz' => $question->getQuiz()->getId(),
                'type' => 'multiple',
                'difficulty' => $question->getQuiz()->getDifficulty()->getLevel(),
                'category' => $question->getQuiz()->getCategory()->getName(),
                'question' => $question->getText(),
                'correct_answer' => $question->getCorrectAnswer(),
                'incorrect_answers' => $question->getIncorrectAnswers(),
                'answers' => array_merge($newArray, $question->getIncorrectAnswers()),
                'id' => $question->getId(),
                'text' => $question->getText(), // Assume que text est la même chose que question
                'answer' => 0,
                'choices' => array_map(function ($choice) {
                    return [
                        'id' => $choice->getId(),
                        'text' => $choice->getText(),
                    ];
                }, $question->getChoices()->toArray()),
            ];
        }

        $randomKeys = array_rand($data, 5);

        if (!is_array($randomKeys)) {
            $randomKeys = [$randomKeys];
        }

        $randomObjects = [];

        foreach ($randomKeys as $key) {
            $randomObjects[] = $data[$key];
        }

        return new JsonResponse(
            $this->serializer->serialize(
                $randomObjects,
                'json',
                [
                    'groups' => Menu::SET_USER_MENU,
                ],
            ),
            json: true,
        );
    }
}
