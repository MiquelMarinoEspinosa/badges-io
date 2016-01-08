<?php

namespace Domain\Entity\Badge;

interface BadgeCollectionDataTransformer
{
    /**
     * @param Badge[] $badges
     *
     * @return mixed
     */
    public function transform($badges);
}
