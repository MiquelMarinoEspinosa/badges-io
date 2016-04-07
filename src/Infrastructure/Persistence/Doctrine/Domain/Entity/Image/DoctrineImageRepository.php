<?php

namespace Infrastructure\Persistence\Doctrine\Domain\Entity\Image;

use Doctrine\ORM\EntityManager;
use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageRepository;

class DoctrineImageRepository implements ImageRepository
{
    /** @var EntityManager */
    private $entityManager;

    /** @var \Doctrine\ORM\EntityRepository */
    private $entityRepository;

    public function __construct($entityManager)
    {
        $this->entityManager    = $entityManager;
        $this->entityRepository = $this->entityManager->getRepository(Image::class);
    }

    public function persist(Image $image)
    {
        $this->entityManager->persist($image);
        $this->entityManager->flush($image);
    }

    /**
     * @param string $id
     *
     * @return Image | null
     */
    public function find($id)
    {
        return $this->entityRepository->find($id);
    }

    /**
     * @param Image $image
     */
    public function remove(Image $image)
    {
        $this->entityManager->remove($image);
        $this->entityManager->flush($image);
    }
}
