<?php

namespace Infrastructure\Persistence\InMemory\Domain\Entity\Badge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\User\User;

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
    public function findByUser(User $user)
    {
        $aListBadges = [];
        foreach ($this->badges as $aBadge) {
            if ($aBadge->user()->id() === $user->id()) {
                $aListBadges[] = $aBadge;
            }
        }

        return $aListBadges;
    }

    /**
     * {@inheritdoc}
     */
    public function findMultiUser()
    {
        $aListBadges = [];
        foreach ($this->badges as $aBadge) {
            if ($aBadge->isMultiUser()) {
                $aListBadges[] = $aBadge;
            }
        }

        return $aListBadges;
    }
}
