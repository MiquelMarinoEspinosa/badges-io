<?php

namespace Infrastructure\DataTransformer\Domain\User;

use Domain\Entity\User\User;
use Domain\Entity\User\UserDataTransformer;

class UserNoOpDataTransformer implements UserDataTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform(User $user)
    {
        return $user;
    }
}
