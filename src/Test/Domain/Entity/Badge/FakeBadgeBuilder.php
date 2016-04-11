<?php

namespace Test\Domain\Entity\Badge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Image\Image;
use Domain\Entity\User\User;

class FakeBadgeBuilder extends Badge
{
    /**
     * @param string $id
     * @param string $name
     * @param string $description
     * @param bool $isMultiTenant
     * @param User $user
     * @param Image $image
     *
     * @return FakeBadgeBuilder
     */
    public static function build($id, $name, $description, $isMultiTenant, User $user, Image $image)
    {
        return new self($id, $name, $description, $isMultiTenant, $user, $image);
    }
}
