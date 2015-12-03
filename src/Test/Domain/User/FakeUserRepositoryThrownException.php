<?php

namespace Test\Domain\User;

use Domain\User\User;
use Domain\User\UserRepository;

class FakeUserRepositoryThrownException implements UserRepository
{
    const FIND_BY_USER_NAME_METHOD_THROW_EXCEPTION  = -1;
    const FIND_BY_EMAIL_METHOD_THROW_EXCEPTION      = -2;
    const PERSIST_METHOD_THROW_EXCEPTION            = -3;

    /** @var  User[] */
    private $users;
    /**
     * @var int
     */
    private $methodException;

    /**
     * @param User[] $users
     * @param int $methodException
     */
    public function __construct($users, $methodException)
    {
        $this->users            = $users;
        $this->methodException  = $methodException;
    }

    /**
     * {@inheritdoc}
     */
    public function findByUserName($userName)
    {
        $this->checkIfHasToThrownAnException(static::FIND_BY_USER_NAME_METHOD_THROW_EXCEPTION);
        $aNullUser = null;
        foreach ($this->users as $user) {
            if ($user->userName() == $userName) {
                return $user;
            }
        }

        return $aNullUser;
    }

    /**
     * {@inheritdoc}
     */
    public function findByEmail($email)
    {
        $this->checkIfHasToThrownAnException(static::FIND_BY_EMAIL_METHOD_THROW_EXCEPTION);
        $aNullUser = null;
        foreach ($this->users as $user) {
            if ($user->email() == $email) {
                return $user;
            }
        }

        return $aNullUser;
    }

    /**
     * {@inheritdoc}
     */
    public function persist(User $user)
    {
        $this->checkIfHasToThrownAnException(static::PERSIST_METHOD_THROW_EXCEPTION);
        $this->users[] = $user;
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
