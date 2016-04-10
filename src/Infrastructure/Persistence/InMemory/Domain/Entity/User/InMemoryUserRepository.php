<?php

namespace Infrastructure\Persistence\InMemory\Domain\Entity\User;

use Domain\Entity\User\User;
use Domain\Entity\User\UserRepository;

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
    public function find($id)
    {
        $aNullUser = null;
        foreach ($this->users as $user) {
            if ($user->id() == $id) {
                return $user;
            }
        }

        return $aNullUser;
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
