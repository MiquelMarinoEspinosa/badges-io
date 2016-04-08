<?php

namespace Test\Domain\Entity\Image;

use Domain\Entity\Image\Image;
use Infrastructure\Persistence\InMemory\Domain\Entity\Image\InMemoryImageRepository;

class FakeImageRepositoryThrownException extends InMemoryImageRepository
{
    const PERSIST_THROW_EXCEPTION = -1;
    const REMOVE_THROW_EXCEPTION  = -3;

    /**
     * @var int
     */
    private $methodException;

    /**
     * @param int $methodException
     * @param array $images
     */
    public function __construct($methodException, $images = [])
    {
        $this->methodException = $methodException;
        parent::__construct($images);
    }

    /**
     * {@inheritdoc}
     */
    public function persist(Image $image)
    {
        $this->checkIfHasToThrownAnException(static::PERSIST_THROW_EXCEPTION);
        parent::persist($image);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Image $image)
    {
        $this->checkIfHasToThrownAnException(static::REMOVE_THROW_EXCEPTION);
        parent::remove($image);
    }

    /**
     * @param int $methodException
     *
     * @throws \Exception
     */
    private function checkIfHasToThrownAnException($methodException)
    {
        if ($this->methodException === $methodException) {
            throw new \Exception();
        }
    }
}
