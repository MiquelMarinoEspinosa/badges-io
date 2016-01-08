<?php

namespace Domain\Entity\Badge;

use Domain\Entity\Tenant\Tenant;

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
     * @param Tenant $tenant
     *
     * @return Badge[]
     */
    public function findByTenant(Tenant $tenant);

    /**
     * @return Badge[]
     */
    public function findMultiTenant();
}
