<?php

namespace Domain\Entity\Badge;

use Domain\Entity\User\User;

interface BadgeRepository
{
    /**
     * @param Badge $badge
     */
    public function persist(Badge $badge);

    /**
     * @param string $id
     *
     * @return Badge | null
     */
    public function find($id);

    /**
     * @param Badge $badge
     */
    public function remove(Badge $badge);

    /**
     * @param User $user
     *
     * @return Badge[]
     */
    public function findByUser(User $user);

    /**
     * @return Badge[]
     */
    public function findMultiUser();
}
