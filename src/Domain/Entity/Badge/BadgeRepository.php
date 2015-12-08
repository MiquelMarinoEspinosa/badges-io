<?php

namespace Domain\Entity\Badge;

interface BadgeRepository
{
    public function persist(Badge $badge);

    /**
     * @param string $id
     *
     * @return Badge | null
     */
    public function find($id);
}
