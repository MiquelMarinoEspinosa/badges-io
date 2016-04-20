<?php

namespace Infrastructure\Resource\Command\Domain\Entity\Badge;

class BadgeCommandCollectionResource
{
    /**
     * @var BadgeCommandResource[]
     */
    private $badgeCommandResources;

    public function __construct($badgeApiResources)
    {
        $this->badgeCommandResources = $badgeApiResources;
    }

    /**
     * @return BadgeCommandResource[]
     */
    public function badgeCommandResources()
    {
        return $this->badgeCommandResources;
    }
}
