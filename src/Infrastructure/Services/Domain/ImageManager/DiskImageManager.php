<?php

namespace Infrastructure\Services\Domain\ImageManager;

use Domain\Service\ImageManager;

class DiskImageManager implements ImageManager
{
    const ROOT_IMAGE_PATH = __DIR__ . '/../../../../../badgesio/bundles/gamification/';

    /**
     * {@inheritdoc}
     */
    public function upload($toPath, $imageId, $imageFormat)
    {
        $this->buildRootImageDirIfNotExists();
        $this->tryToSaveImageToDisk($toPath, $this->buildFileName($imageId, $imageFormat));
    }

    private function buildRootImageDirIfNotExists()
    {
        if (!is_dir(static::ROOT_IMAGE_PATH)) {
            mkdir(static::ROOT_IMAGE_PATH);
        }
    }

    /**
     * @param string $imageId
     * @param string $imageFormat
     *
     * @return string
     */
    private function buildFileName($imageId, $imageFormat)
    {
        return static::ROOT_IMAGE_PATH . $imageId . "." . $imageFormat;
    }

    /**
     * @param string $toPath
     * @param string $imageFileName
     *
     * @throws \Exception
     */
    private function tryToSaveImageToDisk($toPath, $imageFileName)
    {
        if (!move_uploaded_file($toPath, $imageFileName)) {
            throw new \Exception('Not able to create the image file');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildPath($id)
    {
        // TODO: Implement buildPath() method.
    }
}
