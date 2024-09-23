<?php

declare(strict_types=1);

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Transport\Controller\Api\v1\Reporting;

use App\Crm\Application\Service\Project\ProjectStatisticService;
use App\Crm\Application\Service\Reporting\ProjectDetails\ProjectDetailsForm;
use App\Crm\Application\Service\Reporting\ProjectDetails\ProjectDetailsQuery;
use App\Crm\Application\Service\Utils\PageSetup;
use App\Crm\Transport\Controller\Api\v1\AbstractController;
use OpenApi\Attributes as OA;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @package App\Crm\Transport\Controller\Api\v1\Reporting
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
#[AsController]
#[OA\Tag(name: 'Crm Report Management')]
final class ProjectDetailsController extends AbstractController
{
    #[Route(path: '/reporting/project_details', name: 'report_project_details', methods: ['GET'])]
    #[IsGranted('report:project')]
    #[IsGranted(new Expression("is_granted('details', 'project')"))]
    public function __invoke(Request $request, ProjectStatisticService $service): Response
    {
        $dateFactory = $this->getDateTimeFactory();
        $user = $this->getUser();

        $query = new ProjectDetailsQuery($dateFactory->createDateTime(), $user);
        $form = $this->createFormForGetRequest(ProjectDetailsForm::class, $query);
        $form->submit($request->query->all(), false);

        $projectView = null;
        $projectDetails = null;
        $project = $query->getProject();

        if ($project !== null && $this->isGranted('details', $project)) {
            $projectViews = $service->getProjectView($user, [$project], $query->getToday());
            $projectView = $projectViews[0];
            $projectDetails = $service->getProjectsDetails($query);
        }

        $page = new PageSetup('projects');
        $page->setHelp('project.html');

        if ($project !== null) {
            $page->setActionName('project');
            $page->setActionView('project_details_report');
            $page->setActionPayload([
                'project' => $project,
            ]);
        }

        return $this->render('reporting/project_details.html.twig', [
            'page_setup' => $page,
            'report_title' => 'report_project_details',
            'project' => $project,
            'project_view' => $projectView,
            'project_details' => $projectDetails,
            'form' => $form->createView(),
            'now' => $this->getDateTimeFactory()->createDateTime(),
        ]);
    }
}
