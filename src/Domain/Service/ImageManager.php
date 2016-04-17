<?php

namespace Domain\Service;

interface ImageManager
{
    /**
     * @param string $toPath
     * @param string $id
     * @param string $format
     */
    public function upload($toPath, $id, $format);

    /**
     * @param string $id
     * @param string $format
     */
    public function buildPath($id, $format);
}
