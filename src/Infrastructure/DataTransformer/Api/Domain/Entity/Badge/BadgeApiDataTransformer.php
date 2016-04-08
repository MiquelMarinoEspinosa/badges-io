<?php

namespace Infrastructure\DataTransformer\Api\Domain\Entity\Badge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeDataTransformer;
use Infrastructure\DataTransformer\Api\Domain\Entity\Image\ImageApiDataTransformer;
use Infrastructure\DataTransformer\Api\Domain\Entity\Tenant\TenantApiDataTransformer;
use Infrastructure\Resource\Api\Domain\Entity\Badge\BadgeApiResource;

class BadgeApiDataTransformer implements BadgeDataTransformer
{
    /**
     * @var ImageApiDataTransformer
     */
    private $imageApiDataTransformer;
    /**
     * @var TenantApiDataTransformer
     */
    private $tenantApiDataTransformer;

    public function __construct(
        ImageApiDataTransformer $imageApiDataTransformer,
        TenantApiDataTransformer $tenantApiDataTransformer
    ) {
        $this->imageApiDataTransformer  = $imageApiDataTransformer;
        $this->tenantApiDataTransformer = $tenantApiDataTransformer;
    }
    /**
     * {@inheritdoc}
     */
    public function transform(Badge $badge)
    {
        $tenantApiResource = $this->tenantApiDataTransformer->transform($badge->tenant());
        $imageApiResource  = $this->imageApiDataTransformer->transform($badge->image());

        return new BadgeApiResource(
            $badge->id(),
            $badge->name(),
            $badge->description(),
            $badge->isMultiTenant(),
            $tenantApiResource,
            $imageApiResource
        );
    }
}
