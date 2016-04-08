<?php

namespace Domain\Entity\Image;

interface ImageDataTransformer
{
    /**
     * @param Image $image
     *
     * @return mixed
     */
    public function transform(Image $image);
}
