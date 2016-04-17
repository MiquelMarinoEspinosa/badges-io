<?php

namespace Test\Domain\Service;

class FakeImageManagerThrownException extends FakeImageManager
{
    const UPLOAD_THROW_EXCEPTION = -1;
    const REMOVE_THROW_EXCEPTION = -2;

    /**
     * @var int
     */
    private $methodException;

    public function __construct($methodException)
    {
        $this->methodException = $methodException;
    }

    /**
     * {@inheritdoc}
     */
    public function upload($toPath, $id, $format)
    {
        $this->checkIfHasToThrownAnException(static::UPLOAD_THROW_EXCEPTION);
        parent::upload($toPath, $id, $format);
    }

    public function remove($id, $format)
    {
        $this->checkIfHasToThrownAnException(static::REMOVE_THROW_EXCEPTION);
        parent::remove($id, $format);
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
