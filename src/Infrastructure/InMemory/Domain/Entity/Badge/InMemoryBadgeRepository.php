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
        foreach ($this->badges as $aBadge) {
            if ($aBadge->id() === $id) {
                return $aBadge;
            }
        }

        return $aNullBadge;
    }

    public function remove(Badge $badge)
    {
        $aNullBadge = null;
        foreach ($this->badges as $badgeIndex => $aBadge) {
            if ($badge->id() === $aBadge->id()) {
                unset($this->badges[$badgeIndex]);
                return;
            }
        }
    }
}
