<?php

declare(strict_types=1);

namespace App\Media\Application\Service;

use App\Media\Domain\Entity\Media;
use App\Media\Domain\Entity\MediaFolder;
use App\Media\Domain\Entity\MediaThumbnail;
use Doctrine\ORM\EntityManagerInterface;
use Intervention\Image\ImageManager;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MediaService
 *
 * @package App\Media\Application\Service
 * @author  Rami Aouinti <rami.aouinti@tkdeutschland.de>
 */
class MediaService
{
    private FilesystemOperator $storage;
    private EntityManagerInterface $em;
    private ImageManager $imageManager;

    public function __construct(
        FilesystemOperator $storage,
        EntityManagerInterface $em,
        ImageManager $imageManager
    ) {
        $this->storage = $storage;
        $this->em = $em;
        $this->imageManager = $imageManager;
    }

    /**
     * @throws FilesystemException
     */
    public function uploadMedia(UploadedFile $file, string $path, ?MediaFolder $folder = null): Media
    {
        $stream = fopen($file->getPathname(), 'r');
        $this->storage->writeStream($path . '/' . $file->getClientOriginalName(), $stream);

        if (is_resource($stream)) {
            fclose($stream);
        }

        $media = new Media();
        $media->setName($file->getClientOriginalName());
        $media->setMimeType($file->getClientMimeType());
        $media->setFileExtension($file->guessExtension());
        $media->setFileSize($file->getSize());
        $media->setPath($path);
        $media->setMediaFolder($folder);
        $media->setContextKey('Job');
        $data = [
            "original_name" => "document.pdf",
            "mime_type"=> "application/pdf",
            "size"=> 1048576,
            "extension"=> "pdf",
            "temporary_path"=> "/tmp/php7F5.tmp"
        ];
        $media->setMetaData($data);
        $this->em->persist($media);
        $this->em->flush();

        return $media;
    }

    /**
     * @throws FilesystemException
     */
    private function generateThumbnails(Media $media): void
    {
        $stream = $this->storage->readStream($media->getPath());

        $image = $this->imageManager->read($stream);

        $sizes = [
            ['width' => 150, 'height' => 150],
            ['width' => 300, 'height' => 300],
        ];

        foreach ($sizes as $size) {
            $thumbnailPath = 'thumbnails/' . $size['width'] . 'x' . $size['height'] . '/' .  basename($media->getPath());

            $image->resize($size['width'], $size['height']);

            $this->storage->write($thumbnailPath, (string) $image->encode());

            $thumbnail = new MediaThumbnail();
            $thumbnail->setMedia($media);
            $thumbnail->setWidth($size['width']);
            $thumbnail->setHeight($size['height']);
            $thumbnail->setPath($thumbnailPath);

            $this->em->persist($thumbnail);
        }

        $this->em->flush();
    }


    /**
     * @throws FilesystemException
     */
    public function deleteMedia(string $path): void
    {
        $this->storage->delete($path);
    }
}
