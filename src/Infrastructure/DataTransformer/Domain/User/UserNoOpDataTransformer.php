<?php

namespace Infrastructure\DataTransformer\Domain\User;

use Domain\User\User;
use Domain\User\UserDataTransformer;

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
