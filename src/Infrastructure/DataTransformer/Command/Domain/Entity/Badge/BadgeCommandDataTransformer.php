<?php

namespace Infrastructure\DataTransformer\Command\Domain\Entity\Badge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeDataTransformer;
use Infrastructure\DataTransformer\Command\Domain\Entity\Image\ImageCommandDataTransformer;
use Infrastructure\DataTransformer\Command\Domain\Entity\User\UserCommandDataTransformer;
use Infrastructure\Resource\Command\Domain\Entity\Badge\BadgeCommandResource;

class BadgeCommandDataTransformer implements BadgeDataTransformer
{
    /**
     * @var ImageCommandDataTransformer
     */
    private $imageCommandDataTransformer;
    /**
     * @var UserCommandDataTransformer
     */
    private $userCommandDataTransformer;

    public function __construct(
        ImageCommandDataTransformer $imageApiDataTransformer,
        UserCommandDataTransformer $userApiDataTransformer
    ) {
        $this->imageCommandDataTransformer = $imageApiDataTransformer;
        $this->userCommandDataTransformer  = $userApiDataTransformer;
    }
    /**
     * {@inheritdoc}
     */
    public function transform(Badge $badge)
    {
        $userCommandResource = $this->userCommandDataTransformer->transform($badge->user());
        $imageCommandResource  = $this->imageCommandDataTransformer->transform($badge->image());

        return new BadgeCommandResource(
            $badge->id(),
            $badge->name(),
            $badge->description(),
            $badge->isMultiUser(),
            $userCommandResource,
            $imageCommandResource
        );
    }
}
