<?php

namespace Infrastructure\DataTransformer\Command\Domain\Entity\Badge;

use Domain\Entity\Badge\BadgeCollectionDataTransformer;

class BadgeCommandCollectionDataTransformer implements BadgeCollectionDataTransformer
{
    /**
     * @var BadgeCommandDataTransformer
     */
    private $badgeCommandDataTransformer;

    public function __construct(BadgeCommandDataTransformer $badgeCommandDataTransformer)
    {
        $this->badgeCommandDataTransformer = $badgeCommandDataTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($badges)
    {
        $badgeCommandResourcesCollection = [];
        foreach ($badges as $badge) {
            $badgeCommandResourcesCollection[] = $this->badgeCommandDataTransformer->transform($badge);
        }

        return $badgeCommandResourcesCollection;
    }
}
