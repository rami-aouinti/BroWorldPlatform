<?php

declare(strict_types=1);

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Crm\Transport\Twig\Runtime;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium;
use Endroid\QrCode\Writer\PngWriter;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Class QrCodeExtension
 *
 * @package App\Crm\Transport\Twig\Runtime
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
final class QrCodeExtension implements RuntimeExtensionInterface
{
    public function __construct()
    {
    }

    /**
     * @param string $data
     * @param array<string, mixed> $writerOptions
     * @return string
     */
    public function qrCodeDataUriFunction(string $data, array $writerOptions = []): string
    {
        return Builder::create()
            ->writer(new PngWriter())
            ->writerOptions($writerOptions)
            ->data($data)
            // if this causes errors at some point and needs to be configurable, keep this default!
            ->errorCorrectionLevel(new ErrorCorrectionLevelMedium())
            ->build()
            ->getDataUri();
    }
}
