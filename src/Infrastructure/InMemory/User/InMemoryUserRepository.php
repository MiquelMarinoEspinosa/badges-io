<?php

namespace Infrastructure\InMemory\User;

use Domain\User\User;
use Domain\User\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    /** @var  User[] */
    private $users;

    /**
     * @param User[] $users
     */
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
     * {@inheritdoc}
     */
    public function findByUserName($userName)
    {
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
        $this->users[] = $user;
    }
}
