<?php

namespace Infrastructure\DataTransformer\Api\Domain\Entity\Image;

use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageDataTransformer;
use Infrastructure\Resource\Api\Domain\Entity\Image\ImageApiResource;
use Infrastructure\Services\Domain\ImageManager\DiskImageManager;

class ImageApiDataTransformer implements ImageDataTransformer
{
    const DOMAIN_NAME = 'http://badges-io-dev/';

    /**
     * @var DiskImageManager
     */
    private $diskImageManager;

    public function __construct(DiskImageManager $diskImageManager)
    {
        $this->diskImageManager = $diskImageManager;
    }

    /**
     * {@inheritdoc}
     */
    public function transform(Image $image)
    {
        return new ImageApiResource(
            $image->id(),
            $image->name(),
            $image->width(),
            $image->height(),
            $image->format(),
            $this->buildAbsoluteUrl($image)
        );
    }

    /**
     * @param Image $image
     * @return string
     */
    private function buildAbsoluteUrl(Image $image)
    {
        return $this->buildRootPath() . $this->buildRelativePath($image);
    }

    /**
     * @return string
     */
    private function buildRootPath()
    {
        return static::DOMAIN_NAME;
    }

    /**
     * @param Image $image
     * @return string
     */
    private function buildRelativePath(Image $image)
    {
        return $this->diskImageManager->buildPath($image->id(), $image->format());
    }
}
