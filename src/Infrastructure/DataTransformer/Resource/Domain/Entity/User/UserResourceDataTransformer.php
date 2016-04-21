<?php

namespace Infrastructure\DataTransformer\Resource\Domain\Entity\User;

use Domain\Entity\User\User;
use Domain\Entity\User\UserDataTransformer;
use Infrastructure\Resource\Domain\Entity\User\UserResource;

class UserResourceDataTransformer implements UserDataTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform(User $user)
    {
        return new UserResource(
            $user->id(),
            $user->email(),
            $user->userName(),
            $user->passWord()
        );
    }
}
