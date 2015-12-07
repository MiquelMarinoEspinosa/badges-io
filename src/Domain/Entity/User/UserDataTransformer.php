<?php

namespace Domain\Entity\User;

interface UserDataTransformer
{
    /**
     * @param User $user
     *
     * @return mixed
     */
    public function transform(User $user);
}
