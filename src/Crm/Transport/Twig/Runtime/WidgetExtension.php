<?php

declare(strict_types=1);
/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Transport\Twig\Runtime;

use App\User\Domain\Entity\User;
use App\Crm\Application\Service\Widget\WidgetInterface;
use App\Crm\Application\Service\Widget\WidgetService;
use InvalidArgumentException;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\RuntimeExtensionInterface;

use function is_string;

/**
 * Class WidgetExtension
 *
 * @package App\Crm\Transport\Twig\Runtime
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
final class WidgetExtension implements RuntimeExtensionInterface
{
    public function __construct(private WidgetService $service, private Security $security)
    {
    }

    /**
     * @param Environment            $environment
     * @param WidgetInterface|string $widget
     * @param array                  $options
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @return string
     */
    public function renderWidget(Environment $environment, $widget, array $options = []): string
    {
        if (!($widget instanceof WidgetInterface) && !is_string($widget)) {
            throw new InvalidArgumentException('Widget must be either a WidgetInterface or a string');
        }

        if (is_string($widget)) {
            if (!$this->service->hasWidget($widget)) {
                throw new InvalidArgumentException(sprintf('Unknown widget "%s" requested', $widget));
            }

            $widget = $this->service->getWidget($widget);
        }

        $user = $this->security->getUser();
        if ($user instanceof User) {
            $widget->setUser($user);
        }

        $options = $widget->getOptions($options);

        return $environment->render($widget->getTemplateName(), [
            'data' => $widget->getData($options),
            'options' => $options,
            'title' => $widget->getTitle(),
            'widget' => $widget,
        ]);
    }
}
