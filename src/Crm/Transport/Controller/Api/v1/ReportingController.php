<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Transport\Controller\Api\v1;

use App\Crm\Application\Service\Reporting\ReportingService;
use App\Crm\Application\Service\Utils\PageSetup;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Controller used to render reports.
 */
#[AsController]
#[Route(path: '/reporting')]
#[IsGranted('view_reporting')]
#[OA\Tag(name: 'Crm Reporting Management')]
final class ReportingController extends AbstractController
{
    #[Route(path: '/', name: 'reporting', methods: ['GET'])]
    public function defaultReport(ReportingService $reportingService): Response
    {
        $page = new PageSetup('menu.reporting');
        $page->setHelp('reporting.html');

        return $this->render('reporting/index.html.twig', [
            'page_setup' => $page,
            'reports' => $reportingService->getAvailableReports($this->getUser()),
        ]);
    }
}
