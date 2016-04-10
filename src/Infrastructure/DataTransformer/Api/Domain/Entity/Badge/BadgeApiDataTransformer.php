<?php

namespace Infrastructure\DataTransformer\Api\Domain\Entity\Badge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeDataTransformer;
use Infrastructure\DataTransformer\Api\Domain\Entity\Image\ImageApiDataTransformer;
use Infrastructure\DataTransformer\Api\Domain\Entity\User\UserApiDataTransformer;
use Infrastructure\Resource\Api\Domain\Entity\Badge\BadgeApiResource;

class BadgeApiDataTransformer implements BadgeDataTransformer
{
    /**
     * @var ImageApiDataTransformer
     */
    private $imageApiDataTransformer;
    /**
     * @var UserApiDataTransformer
     */
    private $userApiDataTransformer;

    public function __construct(
        ImageApiDataTransformer $imageApiDataTransformer,
        UserApiDataTransformer $userApiDataTransformer
    ) {
        $this->imageApiDataTransformer  = $imageApiDataTransformer;
        $this->userApiDataTransformer = $userApiDataTransformer;
    }
    /**
     * {@inheritdoc}
     */
    public function transform(Badge $badge)
    {
        $userApiResource = $this->userApiDataTransformer->transform($badge->user());
        $imageApiResource  = $this->imageApiDataTransformer->transform($badge->image());

        return new BadgeApiResource(
            $badge->id(),
            $badge->name(),
            $badge->description(),
            $badge->isMultiUser(),
            $userApiResource,
            $imageApiResource
        );
    }
}
