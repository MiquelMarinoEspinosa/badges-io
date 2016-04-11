<?php

namespace Test\Domain\Entity\Badge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\User\User;
use Infrastructure\Persistence\InMemory\Domain\Entity\Badge\InMemoryBadgeRepository;

class FakeBadgeRepositoryThrownException extends InMemoryBadgeRepository
{
    const PERSIST_THROW_EXCEPTION               = -1;
    const FIND_THROW_EXCEPTION                  = -2;
    const REMOVE_THROW_EXCEPTION                = -3;
    const FIND_BY_USER_THROW_EXCEPTION        = -4;
    const FIND_BY_MULTI_USER_THROW_EXCEPTION  = -5;

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

    /**
     * {@inheritdoc}
     */
    public function persist(Badge $badge)
    {
        $this->checkIfHasToThrownAnException(static::PERSIST_THROW_EXCEPTION);
        parent::persist($badge);
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $this->checkIfHasToThrownAnException(static::FIND_THROW_EXCEPTION);

        return parent::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Badge $badge)
    {
        $this->checkIfHasToThrownAnException(static::REMOVE_THROW_EXCEPTION);
        parent::remove($badge);
    }

    /**
     * {@inheritdoc}
     */
    public function findByUser(User $user)
    {
        $this->checkIfHasToThrownAnException(static::FIND_BY_USER_THROW_EXCEPTION);
        return parent::findByUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function findMultiUser()
    {
        $this->checkIfHasToThrownAnException(static::FIND_BY_MULTI_USER_THROW_EXCEPTION);
        return parent::findMultiUser();
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
