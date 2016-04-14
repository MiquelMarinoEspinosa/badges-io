<?php

namespace Infrastructure\Resource\Api\Domain\Entity\Badge;

class BadgeApiCollectionResource
{
    /**
     * @var BadgeApiResource[]
     */
    private $badgeApiResources;

    public function __construct($badgeApiResources)
    {
        $this->badgeApiResources = $badgeApiResources;
    }

    /**
     * @return BadgeApiResource
     */
    public function badgeApiResources()
    {
        return $this->badgeApiResources;
    }
}
