<?php

namespace Domain\Service;

interface ImageManager
{
    /**
     * @param string $toPath
     * @param string $imageId
     * @param string $imageFormat
     */
    public function upload($toPath, $imageId, $imageFormat);

    /**
     * @param string $id
     */
    public function buildPath($id);
}
