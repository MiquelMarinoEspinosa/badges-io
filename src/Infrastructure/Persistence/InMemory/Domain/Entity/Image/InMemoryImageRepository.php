<?php

namespace Infrastructure\Persistence\InMemory\Domain\Entity\Image;

use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageRepository;

class InMemoryImageRepository implements ImageRepository
{
    /**
     * @var Image[]
     */
    private $images;

    public function __construct($images = [])
    {
        $this->images = $images;
    }

    public function persist(Image $image)
    {
        $this->images[] = $image;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $aNullImage = null;
        foreach ($this->images as $image) {
            if ($image->id() === $id) {
                return $image;
            }
        }

        return $aNullImage;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Image $image)
    {
        $aNullImage = null;
        foreach ($this->images as $imageIndex => $anImage) {
            if ($image->id() === $anImage->id()) {
                unset($this->images[$imageIndex]);
                return;
            }
        }
    }
}
