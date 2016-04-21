<?php

namespace Infrastructure\DataTransformer\Resource\Domain\Entity\Badge;

use Domain\Entity\Badge\BadgeCollectionDataTransformer;

class BadgeCollectionResourceDataTransformer implements BadgeCollectionDataTransformer
{
    /**
     * @var BadgeResourceDataTransformer
     */
    private $badgeResourceDataTransformer;

    public function __construct(BadgeResourceDataTransformer $badgeResourceDataTransformer)
    {
        $this->badgeResourceDataTransformer = $badgeResourceDataTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($badges)
    {
        $badgeResourceResourcesCollection = [];
        foreach ($badges as $badge) {
            $badgeResourceResourcesCollection[] = $this->badgeResourceDataTransformer->transform($badge);
        }

        return $badgeResourceResourcesCollection;
    }
}
