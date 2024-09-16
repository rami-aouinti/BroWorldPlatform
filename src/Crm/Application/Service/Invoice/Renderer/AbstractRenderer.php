<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Application\Service\Invoice\Renderer;

use App\Crm\Application\Service\Invoice\InvoiceFilename;
use App\Crm\Application\Service\Invoice\InvoiceModel;
use App\Crm\Application\Service\Model\InvoiceDocument;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @internal
 */
abstract class AbstractRenderer
{
    /**
     * @return string[]
     */
    abstract protected function getFileExtensions(): array;

    abstract protected function getContentType(): string;

    public function supports(InvoiceDocument $document): bool
    {
        foreach ($this->getFileExtensions() as $extension) {
            if (stripos($document->getFilename(), $extension) !== false) {
                return true;
            }
        }

        return false;
    }

    protected function buildFilename(InvoiceModel $model): string
    {
        return (string) new InvoiceFilename($model);
    }

    protected function getFileResponse(mixed $file, string $filename): BinaryFileResponse
    {
        $response = new BinaryFileResponse($file);
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);

        $response->headers->set('Content-Type', $this->getContentType());
        $response->headers->set('Content-Disposition', $disposition);
        $response->deleteFileAfterSend(true);

        return $response;
    }
}
