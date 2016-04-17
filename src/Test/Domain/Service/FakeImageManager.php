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
     * {@inheritdoc}
     */
    public function buildPath($id, $format)
    {
        return $id.$format;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($id, $format)
    {
    }
}
