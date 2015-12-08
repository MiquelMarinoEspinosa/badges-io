<?php

namespace Domain\Entity\Badge;

interface BadgeDataTransformer
{
    /**
     * @param Badge $badge
     *
     * @return mixed
     */
    public function transform(Badge $badge);
}
