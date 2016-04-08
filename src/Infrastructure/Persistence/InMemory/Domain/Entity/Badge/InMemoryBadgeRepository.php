<?php

namespace Infrastructure\Persistence\InMemory\Domain\Entity\Badge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\Tenant\Tenant;

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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function findByTenant(Tenant $tenant)
    {
        $aListBadges = [];
        foreach ($this->badges as $aBadge) {
            if ($aBadge->tenant()->id() === $tenant->id()) {
                $aListBadges[] = $aBadge;
            }
        }

        return $aListBadges;
    }

    /**
     * {@inheritdoc}
     */
    public function findMultiTenant()
    {
        $aListBadges = [];
        foreach ($this->badges as $aBadge) {
            if ($aBadge->isMultiTenant()) {
                $aListBadges[] = $aBadge;
            }
        }

        return $aListBadges;
    }
}
