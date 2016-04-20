<?php

namespace Infrastructure\DataTransformer\Command\Domain\Entity\User;

use Domain\Entity\User\User;
use Domain\Entity\User\UserDataTransformer;
use Infrastructure\Resource\Command\Domain\Entity\User\UserCommandResource;

class UserCommandDataTransformer implements UserDataTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform(User $user)
    {
        return new UserCommandResource(
            $user->id(),
            $user->email(),
            $user->userName(),
            $user->passWord()
        );
    }
}
