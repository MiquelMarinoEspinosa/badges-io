<?php

namespace Test\Domain\Entity\Image;

use Domain\Entity\Image\Image;

class FakeImageBuilder extends Image
{
    /**
     * @param string $id
     * @param string $imageName
     * @param int $imageWidth
     * @param int $imageHeight
     * @param string $format
     *
     * @return Image
     */
    public static function build($id, $imageName, $imageWidth, $imageHeight, $format)
    {
        return new self($id, $imageName, $imageWidth, $imageHeight, $format);
    }
}
