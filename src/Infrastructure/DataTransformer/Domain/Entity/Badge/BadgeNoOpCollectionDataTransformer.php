<?php

namespace Infrastructure\DataTransformer\Domain\Entity\Badge;

use Domain\Entity\Badge\BadgeCollectionDataTransformer;

class BadgeNoOpCollectionDataTransformer implements BadgeCollectionDataTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform($badges)
    {
        return $badges;
    }
}
