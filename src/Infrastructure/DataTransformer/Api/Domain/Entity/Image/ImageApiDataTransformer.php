<?php

namespace Infrastructure\DataTransformer\Api\Domain\Entity\Image;

use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageDataTransformer;
use Infrastructure\Resource\Api\Domain\Entity\Image\ImageApiResource;

class ImageApiDataTransformer implements ImageDataTransformer
{
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
            $image->format()
        );
    }
}
