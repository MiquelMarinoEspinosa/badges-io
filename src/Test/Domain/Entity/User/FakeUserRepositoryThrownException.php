<?php

namespace Test\Domain\Entity\User;

use Domain\Entity\User\User;
use Infrastructure\Persistence\InMemory\Domain\Entity\User\InMemoryUserRepository;

class FakeUserRepositoryThrownException extends InMemoryUserRepository
{
    const FIND_BY_USER_NAME_METHOD_THROW_EXCEPTION  = -1;
    const FIND_BY_EMAIL_METHOD_THROW_EXCEPTION      = -2;
    const PERSIST_METHOD_THROW_EXCEPTION            = -3;
    const FIND_BY_ID_METHOD_THROW_EXCEPTION         = -4;

    /**
     * @var int
     */
    private $methodException;

    public function __construct($users, $methodException)
    {
        $this->methodException  = $methodException;
        parent::__construct($users);
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $this->checkIfHasToThrownAnException(static::FIND_BY_ID_METHOD_THROW_EXCEPTION);
        parent::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByUserName($userName)
    {
        $this->checkIfHasToThrownAnException(static::FIND_BY_USER_NAME_METHOD_THROW_EXCEPTION);
        parent::findByUserName($userName);
    }

    /**
     * {@inheritdoc}
     */
    public function findByEmail($email)
    {
        $this->checkIfHasToThrownAnException(static::FIND_BY_EMAIL_METHOD_THROW_EXCEPTION);
        parent::findByEmail($email);
    }

    /**
     * {@inheritdoc}
     */
    public function persist(User $user)
    {
        $this->checkIfHasToThrownAnException(static::PERSIST_METHOD_THROW_EXCEPTION);
        parent::persist($user);
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
