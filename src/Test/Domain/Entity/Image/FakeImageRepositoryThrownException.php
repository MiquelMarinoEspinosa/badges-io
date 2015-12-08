<?php

namespace Test\Domain\Entity\Image;

use Domain\Entity\Image\Image;
use Infrastructure\InMemory\Domain\Entity\Image\InMemoryImageRepository;

class FakeImageRepositoryThrownException extends InMemoryImageRepository
{
    const PERSIST_THROW_EXCEPTION = -1;

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

    public function persist(Image $image)
    {
        $this->checkIfHasToThrownAnException(static::PERSIST_THROW_EXCEPTION);
        parent::persist($image);
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
