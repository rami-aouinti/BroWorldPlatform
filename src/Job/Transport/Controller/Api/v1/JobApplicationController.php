<?php

declare(strict_types=1);

namespace App\Job\Transport\Controller\Api\v1;

use App\Job\Domain\Entity\Applicant;
use App\Job\Domain\Entity\Job;
use App\Job\Domain\Entity\JobApplication;
use App\Job\Infrastructure\Repository\ApplicantRepository;
use App\Job\Infrastructure\Repository\JobApplicationRepository;
use App\Job\Infrastructure\Repository\JobRepository;
use App\Media\Application\Service\MediaService;
use App\Media\Domain\Entity\Media;
use App\Media\Domain\Entity\MediaFolder;
use App\Media\Infrastructure\Repository\MediaFolderRepository;
use App\Media\Infrastructure\Repository\MediaRepository;
use App\User\Domain\Entity\User;
use DateTimeImmutable;
use League\Flysystem\FilesystemException;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\FileinfoMimeTypeGuesser;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class JobApplicationController
 *
 * @package App\Job\Transport\Controller\Api\v1
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[OA\Tag(name: "JobApplication")]
class JobApplicationController extends AbstractController
{

    private MediaService $mediaService;

    private MediaRepository $mediaRepository;

    private MediaFolderRepository $mediaFolderRepository;

    public function __construct(
        MediaService $mediaService,
        MediaRepository $mediaRepository,
        MediaFolderRepository $mediaFolderRepository
    )
    {
        $this->mediaService = $mediaService;
        $this->mediaRepository = $mediaRepository;
        $this->mediaFolderRepository = $mediaFolderRepository;
    }


    /**
     * @throws FilesystemException
     */
    #[Route(path: "/v1/jobs_applications/{job}", methods: "POST")]
    #[OA\Post(description: "Create Job Application.")]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    #[OA\RequestBody(
        description: "Json to create the job application",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "applicant", type: "string", example: "018733dd-d61e-701b-a6fa-7c5254335750"),
                new OA\Property(property: "job", type: "string", example: "018733fc-476c-751d-a49d-4ccd43a11ce9")
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns the ID of the JobApplication',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "statusCode", type: "int", example: 201),
                new OA\Property(property: "message", type: "string", example: "JobApplication created"),
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
        ApplicantRepository $applicantRepository,
        MediaFolderRepository $mediaFolderRepository,
        JobApplicationRepository $applicationRepository,
        Request $request,
        Job $job,
        ValidatorInterface $validator
    ): Response
    {

        $applicant = new Applicant();
        $applicant->setFirstName($request->request->get('firstName'));
        $applicant->setLastName($request->request->get('lastName'));
        $applicant->setUser($loggedInUser);
        $applicant->setCoverLetter($request->request->get('coverLetter'));
        $applicant->setTitle($request->request->get('title'));
        $applicant->setEmail($request->request->get('email'));
        $applicant->setMobile($request->request->get('mobile'));
        $applicant->setAvatar($request->request->get('avatar'));


        $files = $request->files->all('files');

        foreach ($files as $file) {
            $folder = $this->createFolder('Mon Dossier');
            $this->mediaService->uploadMedia($file,'uploads/jobs/application', $folder);

        }

        $applicantRepository->save($applicant);


        $jobApplication = new JobApplication();
        $jobApplication->setJob($job);
        $jobApplication->setApplicant($applicant);
        $jobApplication->setCreatedAt(new DateTimeImmutable());

        $violations = $validator->validate($jobApplication);

        if(count($violations) === 0){
            $applicationRepository->save($jobApplication, true);

            return $this->jsonResponse("Job application created", [
                'id' => $jobApplication->getId(),
            ], 201);
        }

        $errorData = [];
        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation){
            $errorData[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $this->jsonResponse("Invalid input", $errorData, 400);
    }

    private function createFolder(string $name, ?string $parentId = null): MediaFolder
    {
        $folder = new MediaFolder();
        $folder->setName($name);
        $folder->setParent($parentId);
        $this->mediaFolderRepository->save($folder);
        return $folder;
    }

    /**
     * @param string      $path
     * @param MediaFolder $folder
     * @param             $mimeType
     * @param             $extension
     * @param             $fileSize
     *
     * @return void
     */
    private function createMedia(string $path, MediaFolder $folder, $mimeType, $extension, $fileSize): void
    {
        $media = new Media();
        $media->setPath($path);
        $media->setMediaFolder($folder);
        $media->setContextKey('Job');
        $media->setMimeType($mimeType);
        $media->setFileExtension($extension);
        $media->setFileSize($fileSize);
        $media->setPrivate(true);
        $data = [
            "original_name" => "document.pdf",
            "mime_type"=> "application/pdf",
            "size"=> 1048576,
            "extension"=> "pdf",
            "temporary_path"=> "/tmp/php7F5.tmp"
        ];
        $media->setMetaData($data);
        $this->mediaRepository->save($media);
    }

    #[Route(path: "/api/v1/jobs_applications", methods: "GET")]
    #[OA\Get(description: "Return all Job Applications.")]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    public function findAll(JobApplicationRepository $repository): Response
    {
        $jobsApplications = $repository->findAll();

        $response = [];
        foreach ($jobsApplications as $jobsApplication) {
            $response[] = $jobsApplication->toArray();
        }

        return $this->jsonResponse("List of job applications", $response);
    }

    #[Route(path: "/api/v1/jobs_applications/{id}", methods: "GET")]
    #[OA\Get(description: "Return Job Application by ID.")]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    public function findById(JobApplicationRepository $repository, string $id): Response
    {
        $jobApplication = $repository->find($id);

        if ($jobApplication === null) {
            return $this->jsonResponse("Job application not found", ['id' => $id], 404);
        }

        return $this->jsonResponse("Job application by ID", [
            $jobApplication->toArray()
        ]);
    }

    #[Route('/api/v1/jobs_applications/filter-by-applicant/{applicantId}', methods: ['GET'])]
    #[OA\Get(description: "Filter Job Applications by applicant.")]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    public function filterByApplicant(ApplicantRepository $applicantRepository, JobApplicationRepository $repository, string $applicantId): Response
    {
        $applicant = $applicantRepository->find($applicantId);

        if ($applicant === null) {
            return $this->jsonResponse("Applicant not found", ['id' => $applicantId], 404);
        }

        $jobs = $repository->findBy(['applicant' => $applicant]);

        $response = [];
        foreach ($jobs as $job) {
            $response[] = $job->toArray();
        }

        return $this->jsonResponse("List of applications for job", $response);
    }

    #[Route('/api/v1/jobs_applications/filter-by-job/{jobId}', methods: ['GET'])]
    #[OA\Get(description: "Filter Job Applications by job.")]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    public function filterByJob(JobRepository $jobRepository, JobApplicationRepository $repository, string $jobId): Response
    {
        $job = $jobRepository->find($jobId);

        if ($job === null) {
            return $this->jsonResponse("Job not found", ['id' => $jobId], 404);
        }

        $applicants = $repository->findBy(['job' => $job]);

        $response = [];
        foreach ($applicants as $applicant) {
            $response[] = $applicant->toArray();
        }

        return $this->jsonResponse("List of jobs applied by applicant", $response);
    }

    #[Route(path: "/api/v1/jobs_applications/{id}", methods: "DELETE")]
    #[OA\Delete(description: "Delete Job Application by ID.")]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    public function remove(JobApplicationRepository $repository, string $id): Response
    {
        $jobApplication = $repository->find($id);

        if ($jobApplication === null) {
            return $this->jsonResponse("Job application not found", ['id' => $id], 404);
        }

        $repository->remove($jobApplication, true);

        return $this->jsonResponse("Job application deleted", [
            $jobApplication->toArray()
        ]);
    }

    private function jsonResponse(string $message, array $data, int $statusCode = 200): JsonResponse
    {
        return $this->json([
            "statusCode" => $statusCode,
            "message" => $message,
            "data" => $data
        ], $statusCode);
    }
}
