<?php

namespace Domain\Entity\Tenant;

interface TenantRepository
{
    /**
     * @param string $id
     *
     * @return Tenant | null
     */
    public function find($id);
}
