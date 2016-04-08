<?php

namespace Infrastructure\DataTransformer\Api\Domain\Entity\Badge;

use Domain\Entity\Badge\BadgeCollectionDataTransformer;

class BadgeApiCollectionDataTransformer implements BadgeCollectionDataTransformer
{
    /**
     * @var BadgeApiDataTransformer
     */
    private $badgeApiDataTransformer;

    public function __construct(BadgeApiDataTransformer $badgeApiDataTransformer)
    {
        $this->badgeApiDataTransformer = $badgeApiDataTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($badges)
    {
        $badgeApiResourcesCollection = [];
        foreach ($badges as $badge) {
            $badgeApiResourcesCollection[] = $this->badgeApiDataTransformer->transform($badge);
        }

        return $badgeApiResourcesCollection;
    }
}
