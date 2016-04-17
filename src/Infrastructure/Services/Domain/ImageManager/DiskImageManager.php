<?php

namespace Infrastructure\Services\Domain\ImageManager;

use Domain\Service\ImageManager;

class DiskImageManager implements ImageManager
{
    const ROOT_IMAGE_PATH = __DIR__ . '/../../../../../badgesio/bundles/gamification/images';

    /**
     * {@inheritdoc}
     */
    public function upload($toPath, $id, $format)
    {
        $this->buildRootImageDirIfNotExists();
        $this->tryToSaveImageToDisk($toPath, $this->buildImagePath($id, $format));
    }

    private function buildRootImageDirIfNotExists()
    {
        if (!is_dir(static::ROOT_IMAGE_PATH)) {
            mkdir(static::ROOT_IMAGE_PATH, 0777, true);
        }
    }

    /**
     * @param string $id
     * @param string $format
     *
     * @return string
     */
    private function buildImagePath($id, $format)
    {
        return static::ROOT_IMAGE_PATH . '/' . $this->buildImageFileName($id, $format);
    }

    /**
     * @param string $toPath
     * @param string $fileName
     *
     * @throws \Exception
     */
    private function tryToSaveImageToDisk($toPath, $fileName)
    {
        if (!move_uploaded_file($toPath, $fileName)) {
            throw new \Exception('Not able to create the image file');
        }
    }

    /**
     * @param string $id
     * @param string $format
     *
     * @return string
     */
    public function buildPath($id, $format)
    {
        return $this->buildImageFileName($id, $format);
    }

    /**
     * @param string $id
     * @param string $format
     *
     * @return string
     */
    private function buildImageFileName($id, $format)
    {
        return $id . "." . $format;
    }

    /**
     * @param string $id
     * @param string $format
     */
    public function remove($id, $format)
    {
        $this->tryToRemoveImageFromDisk($id, $format);
    }

    /**
     * @param string $id
     * @param string $format
     *
     * @throws \Exception
     */
    private function tryToRemoveImageFromDisk($id, $format)
    {
        if (!unlink($this->buildImagePath($id, $format))) {
            throw new \Exception('Not able to remove the image file:' . $this->buildImagePath($id, $format));
        }
    }
}
