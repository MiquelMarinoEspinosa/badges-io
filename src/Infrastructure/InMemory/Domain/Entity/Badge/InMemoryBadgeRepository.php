<?php

namespace Infrastructure\InMemory\Domain\Entity\Badge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeRepository;

class InMemoryBadgeRepository implements BadgeRepository
{
    /**
     * @var Badge[]
     */
    private $badges;

    public function __construct($badges = [])
    {
        $this->badges = $badges;
    }

    public function persist(Badge $badge)
    {
        $this->badges[] = $badge;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $aNullBadge = null;
        foreach ($this->badges as $badge) {
            if ($badge->id() === $id) {
                return $badge;
            }
        }

        return $aNullBadge;
    }
}
