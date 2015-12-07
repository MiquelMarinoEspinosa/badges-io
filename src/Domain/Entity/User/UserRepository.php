<?php

namespace Domain\Entity\User;

interface UserRepository
{
    /**
     * @param string $userName
     *
     * @return User|null
     */
    public function findByUserName($userName);

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function findByEmail($email);

    /**
     * @param User $user
     */
    public function persist(User $user);
}
