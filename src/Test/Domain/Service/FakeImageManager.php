<?php

namespace Test\Domain\Service;

use Domain\Service\ImageManager;

class FakeImageManager implements ImageManager
{
    /**
     * {@inheritdoc}
     */
    public function upload($toPath, $id, $format)
    {
    }

    /**
     * @param string $id
     * @param string $format
     *
     * @return string
     */
    public function buildPath($id, $format)
    {
        return $id.$format;
    }
}
