<?php

namespace Infrastructure\DataTransformer\NoOperation\Domain\Entity\Badge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeDataTransformer;

class BadgeNoOpDataTransformer implements BadgeDataTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform(Badge $badge)
    {
        return $badge;
    }
}
