<?php

namespace Infrastructure\DataTransformer\Resource\Domain\Entity\Badge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeDataTransformer;
use Infrastructure\DataTransformer\Resource\Domain\Entity\Image\ImageResourceDataTransformer;
use Infrastructure\DataTransformer\Resource\Domain\Entity\User\UserResourceDataTransformer;
use Infrastructure\Resource\Domain\Entity\Badge\BadgeResource;

class BadgeResourceDataTransformer implements BadgeDataTransformer
{
    /**
     * @var ImageResourceDataTransformer
     */
    private $imageResourceDataTransformer;
    /**
     * @var UserResourceDataTransformer
     */
    private $userResourceDataTransformer;

    public function __construct(
        ImageResourceDataTransformer $imageResourceDataTransformer,
        UserResourceDataTransformer  $userResourceDataTransformer
    ) {
        $this->imageResourceDataTransformer  = $imageResourceDataTransformer;
        $this->userResourceDataTransformer   = $userResourceDataTransformer;
    }
    /**
     * {@inheritdoc}
     */
    public function transform(Badge $badge)
    {
        $userResourceResource = $this->userResourceDataTransformer->transform($badge->user());
        $imageResourceResource  = $this->imageResourceDataTransformer->transform($badge->image());

        return new BadgeResource(
            $badge->id(),
            $badge->name(),
            $badge->description(),
            $badge->isMultiUser(),
            $userResourceResource,
            $imageResourceResource
        );
    }
}
