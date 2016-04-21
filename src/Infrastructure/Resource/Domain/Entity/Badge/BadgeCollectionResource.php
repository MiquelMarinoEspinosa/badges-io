<?php

namespace Infrastructure\Resource\Domain\Entity\Badge;

class BadgeCollectionResource
{
    /**
     * @var BadgeResource[]
     */
    private $badgeResources;

    public function __construct($badgeResources)
    {
        $this->badgeResources = $badgeResources;
    }

    /**
     * @return BadgeResource[]
     */
    public function badgeResources()
    {
        return $this->badgeResources;
    }
}
