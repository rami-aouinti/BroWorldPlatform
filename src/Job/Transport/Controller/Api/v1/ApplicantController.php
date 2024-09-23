<?php

declare(strict_types=1);

namespace App\Job\Transport\Controller\Api\v1;

use App\Job\Domain\Entity\Applicant;
use App\Job\Infrastructure\Repository\ApplicantRepository;
use App\User\Domain\Entity\User;
use DateTimeImmutable;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ApplicantController
 *
 * @package App\Job\Transport\Controller\Api\v1
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[OA\Tag(name: "Applicant")]
class ApplicantController extends AbstractController
{
    #[Route(path: "/v1/applicant", methods: "POST")]
    #[OA\Post(description: "Create category.")]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    #[OA\RequestBody(
        description: "Json to create the company",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "name", type: "string", example: "Applicant Name"),
                new OA\Property(property: "contactEmail", type: "string", example: "applicant@gmail.com"),
                new OA\Property(property: "jobPreferences", type: "string", example: "Job preferences"),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns the ID of the applicant',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "statusCode", type: "int", example: 201),
                new OA\Property(property: "message", type: "string", example: "Applicant created"),
                new OA\Property(property: "data", type: "object")
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Invalid arguments',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "statusCode", type: "int", example: 400),
                new OA\Property(property: "message", type: "string", example: "Invalid arguments"),
                new OA\Property(property: "data", type: "object")
            ]
        )
    )]
    public function create(
        User $loggedInUser,
        ApplicantRepository $repository,
        Request $request,
        ValidatorInterface $validator
    ): Response
    {
        $jsonParams = json_decode($request->getContent(), true);

        $applicant = new Applicant();
        $applicant->setName($jsonParams['name']);
        $applicant->setUser($loggedInUser);
        $applicant->setJobPreferences($jsonParams['jobPreferences']);
        $applicant->setCreatedAt(new DateTimeImmutable());

        $violations = $validator->validate($applicant);

        if(count($violations) === 0){
            $repository->save($applicant, true);

            return $this->jsonResponse("Applicant created", [
                'id'=> $applicant->getId()
            ], 201);
        }

        $errorData = [];
        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation){
            $errorData[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $this->jsonResponse("Invalid input", $errorData, 400);
    }

    #[Route(path: "/v1/applicants", methods: "GET")]
    #[OA\Get(description: "Return all the applicants.")]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    public function findAll(ApplicantRepository $repository): Response
    {
        $applicants = $repository->findAll();

        $response = [];
        foreach ($applicants as $applicant){
            $response[] = $applicant->toArray();
        }

        return $this->jsonResponse("List of Applicants", $response);
    }

    #[Route(path: "/v1/applicant/{id}", methods: "GET")]
    #[OA\Get(description: "Return the applicant by ID.")]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    public function findById(ApplicantRepository $repository, string $id): Response
    {
        $applicant = $repository->find($id);

        if($applicant === null){
            return $this->jsonResponse("Applicant not found",['id'=>$id], 404);
        }

        return $this->jsonResponse("Applicant by ID", $applicant->toArray());
    }

    #[Route(path: "/api/v1/applicants/{id}", methods: "PUT")]
    #[OA\Put(description: "Update the applicant by ID.")]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    #[OA\RequestBody(
        description: "Json to update the applicant",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "name", type: "string", example: "Applicant name"),
                new OA\Property(property: "contactEmail", type: "string", example: "applicant@gmail.com"),
                new OA\Property(property: "jobPreferences", type: "string", example: "Job preferences"),
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the properties of the applicant',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "statusCode", type: "int", example: 200),
                new OA\Property(property: "message", type: "string", example: "Applicant updated"),
                new OA\Property(property: "data", type: "object")
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Invalid arguments',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "statusCode", type: "int", example: 400),
                new OA\Property(property: "message", type: "string", example: "Invalid arguments"),
                new OA\Property(property: "data", type: "object")
            ]
        )
    )]
    public function update(
        User $loggedInUser,
        ApplicantRepository $repository,
        Request $request,
        string $id,
        ValidatorInterface $validator
    ): Response
    {
        $applicant = $repository->find($id);

        if($applicant === null){
            return $this->jsonResponse("Applicant not found",['id'=>$id], 404);
        }

        $jsonParams = json_decode($request->getContent(), true);

        $applicant->setName($jsonParams['name']);
        $applicant->setUser($loggedInUser);
        $applicant->setJobPreferences($jsonParams['jobPreferences']);
        $applicant->setUpdatedAt(new DateTimeImmutable());

        $violations = $validator->validate($applicant);

        if(count($violations) === 0){
            $repository->save($applicant, true);

            return $this->jsonResponse("Applicant updated",[
                $applicant->toArray()
            ]);
        }

        $errorData = [];
        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation){
            $errorData[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $this->jsonResponse("Invalid input", $errorData, 400);
    }

    #[Route(path: "/v1/applicant/{id}", methods: "DELETE")]
    #[OA\Delete(description: "Delete the applicant by ID.")]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    public function remove(ApplicantRepository $repository, string $id): Response
    {
        $applicant = $repository->find($id);

        if($applicant === null){
            return $this->jsonResponse("Applicant not found",['id'=>$id], 404);
        }

        $repository->remove($applicant, true);

        return $this->jsonResponse("Applicant deleted",[
            $applicant->toArray()
        ]);
    }

    private function jsonResponse(string $message, array $data, int $statusCode = 200): JsonResponse
    {
        return $this->json([
            "statusCode"=> $statusCode,
            "message"=> $message,
            "data"=> $data
        ], $statusCode);
    }
}
