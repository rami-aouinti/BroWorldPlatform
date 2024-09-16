<?php

declare(strict_types=1);

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Transport\Twig\Runtime;

use App\Crm\Application\Service\Configuration\SystemConfiguration;
use App\Crm\Application\Service\Utils\Markdown;
use Twig\Extension\RuntimeExtensionInterface;

use function count;
use function strlen;

/**
 * Class MarkdownExtension
 *
 * @package App\Crm\Transport\Twig\Runtime
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
final class MarkdownExtension implements RuntimeExtensionInterface
{
    private ?bool $markdownEnabled = null;

    public function __construct(private readonly Markdown $markdown, private readonly SystemConfiguration $configuration)
    {
    }

    private function isMarkdownEnabled(): bool
    {
        if (null === $this->markdownEnabled) {
            $this->markdownEnabled = $this->configuration->isTimesheetMarkdownEnabled();
        }

        return $this->markdownEnabled;
    }

    /**
     * Transforms entity and user comments (customer, project, activity ...) into HTML.
     *
     * @param string|null $content
     * @param bool $fullLength
     * @return string
     */
    public function commentContent(?string $content, bool $fullLength = true): string
    {
        if (empty($content)) {
            return '';
        }

        if (!$fullLength && strlen($content) > 101) {
            $content = trim(substr($content, 0, 100)) . ' &hellip;';
        }

        if ($this->isMarkdownEnabled()) {
            $content = $this->markdown->toHtml($content);
        } elseif ($fullLength) {
            $content = '<p>' . nl2br(htmlspecialchars($content)) . '</p>';
        }

        return $content;
    }

    /**
     * Transforms the entities comment (customer, project, activity ...) into a one-liner.
     *
     * @param string|null $content
     * @param bool $fullLength
     * @return string
     */
    public function commentOneLiner(?string $content, bool $fullLength = true): string
    {
        if (empty($content)) {
            return '';
        }

        $addHellip = false;

        if (!$fullLength && strlen($content) > 52) {
            $content = trim(substr($content, 0, 50));
            $addHellip = true;
        }

        $content = explode(PHP_EOL, $content);
        $result = $content[0];

        if (count($content) > 1 || $addHellip) {
            $result .= ' &hellip;';
        }

        return $result;
    }

    /**
     * Transforms the timesheet description content into HTML.
     *
     * @param string|null $content
     * @return string
     */
    public function timesheetContent(?string $content): string
    {
        if (empty($content)) {
            return '';
        }

        if ($this->isMarkdownEnabled()) {
            return $this->markdown->toHtml($content);
        }

        return nl2br(htmlspecialchars($content));
    }

    /**
     * Transforms the given Markdown content into HTML
     *
     * @param string $content
     * @return string
     */
    public function markdownToHtml(string $content): string
    {
        return $this->markdown->withFullMarkdownSupport($content);
    }
}
