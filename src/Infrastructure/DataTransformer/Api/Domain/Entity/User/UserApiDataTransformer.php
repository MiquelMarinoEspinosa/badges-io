<?php

namespace Infrastructure\DataTransformer\Api\Domain\Entity\User;

use Domain\Entity\User\User;
use Domain\Entity\User\UserDataTransformer;
use Infrastructure\Resource\Api\Domain\Entity\User\UserApiResource;

class UserApiDataTransformer implements UserDataTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform(User $user)
    {
        return new UserApiResource(
            $user->id(),
            $user->email(),
            $user->userName(),
            $user->passWord()
        );
    }
}
