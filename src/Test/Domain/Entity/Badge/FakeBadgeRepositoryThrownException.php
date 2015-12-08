<?php

namespace Test\Domain\Entity\Badge;

use Domain\Entity\Badge\Badge;
use Infrastructure\InMemory\Domain\Entity\Badge\InMemoryBadgeRepository;

class FakeBadgeRepositoryThrownException extends InMemoryBadgeRepository
{
    const PERSIST_THROW_EXCEPTION = -1;

    /**
     * @var int
     */
    private $methodException;

    /**
     * @param int $methodException
     * @param Badge[] $badges
     */
    public function __construct($methodException, $badges = [])
    {
        $this->methodException = $methodException;
        parent::__construct($badges);
    }

    public function persist(Badge $badge)
    {
        $this->checkIfHasToThrownAnException(static::PERSIST_THROW_EXCEPTION);
        parent::persist($badge);
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
