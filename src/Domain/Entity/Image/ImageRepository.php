<?php

namespace Domain\Entity\Image;

interface ImageRepository
{
    public function persist(Image $image);

    /**
     * @param string $id
     *
     * @return Image | null
     */
    public function find($id);
}