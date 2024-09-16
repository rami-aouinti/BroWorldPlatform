<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Application\Service\Export\Base;

use App\Crm\Application\Service\Activity\ActivityStatisticService;
use App\Crm\Application\Service\Project\ProjectStatisticService;
use App\Crm\Domain\Entity\ExportableItem;
use App\Crm\Domain\Entity\MetaTableTypeInterface;
use App\Crm\Infrastructure\Repository\Query\CustomerQuery;
use App\Crm\Infrastructure\Repository\Query\TimesheetQuery;
use App\Crm\Transport\Event\ActivityMetaDisplayEvent;
use App\Crm\Transport\Event\CustomerMetaDisplayEvent;
use App\Crm\Transport\Event\MetaDisplayEventInterface;
use App\Crm\Transport\Event\ProjectMetaDisplayEvent;
use App\Crm\Transport\Event\TimesheetMetaDisplayEvent;
use App\Crm\Transport\Event\UserPreferenceDisplayEvent;
use App\Crm\Transport\Twig\SecurityPolicy\ExportPolicy;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Extension\SandboxExtension;

class HtmlRenderer
{
    use RendererTrait;

    /**
     * @var string
     */
    private $id = 'html';
    /**
     * @var string
     */
    private $template = 'default.html.twig';

    public function __construct(
        protected Environment $twig,
        protected EventDispatcherInterface $dispatcher,
        private ProjectStatisticService $projectStatisticService,
        private ActivityStatisticService $activityStatisticService
    ) {
    }

    /**
     * @param MetaDisplayEventInterface $event
     * @return MetaTableTypeInterface[]
     */
    protected function findMetaColumns(MetaDisplayEventInterface $event): array
    {
        $this->dispatcher->dispatch($event);

        return $event->getFields();
    }

    protected function getOptions(TimesheetQuery $query): array
    {
        $decimal = false;
        if (null !== $query->getCurrentUser()) {
            $decimal = $query->getCurrentUser()->isExportDecimal();
        } elseif (null !== $query->getUser()) {
            $decimal = $query->getUser()->isExportDecimal();
        }

        return ['decimal' => $decimal];
    }

    /**
     * @param ExportableItem[] $timesheets
     * @param TimesheetQuery $query
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(array $timesheets, TimesheetQuery $query): Response
    {
        /** @var CustomerQuery $customerQuery */
        $customerQuery = $query->copyTo(new CustomerQuery());

        $timesheetMetaFields = $this->findMetaColumns(new TimesheetMetaDisplayEvent($query, TimesheetMetaDisplayEvent::EXPORT));
        $customerMetaFields = $this->findMetaColumns(new CustomerMetaDisplayEvent($customerQuery, CustomerMetaDisplayEvent::EXPORT));
        $projectMetaFields = $this->findMetaColumns(new ProjectMetaDisplayEvent($query, ProjectMetaDisplayEvent::EXPORT));
        $activityMetaFields = $this->findMetaColumns(new ActivityMetaDisplayEvent($query, ActivityMetaDisplayEvent::EXPORT));

        $event = new UserPreferenceDisplayEvent(UserPreferenceDisplayEvent::EXPORT);
        $this->dispatcher->dispatch($event);
        $userPreferences = $event->getPreferences();

        $summary = $this->calculateSummary($timesheets);

        // enable basic security measures
        $sandbox = new SandboxExtension(new ExportPolicy());
        $sandbox->enableSandbox();
        $this->twig->addExtension($sandbox);

        $content = $this->twig->render($this->getTemplate(), array_merge([
            'entries' => $timesheets,
            'query' => $query,
            'summaries' => $summary,
            'budgets' => $this->calculateProjectBudget($timesheets, $query, $this->projectStatisticService),
            'activity_budgets' => $this->calculateActivityBudget($timesheets, $query, $this->activityStatisticService),
            'timesheetMetaFields' => $timesheetMetaFields,
            'customerMetaFields' => $customerMetaFields,
            'projectMetaFields' => $projectMetaFields,
            'activityMetaFields' => $activityMetaFields,
            'userPreferences' => $userPreferences,
        ], $this->getOptions($query)));

        $response = new Response();
        $response->setContent($content);

        return $response;
    }

    protected function getTemplate(): string
    {
        return '@export/' . $this->template;
    }

    public function setTemplate(string $filename): HtmlRenderer
    {
        $this->template = $filename;

        return $this;
    }

    public function setId(string $id): HtmlRenderer
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
