<?php

namespace Infrastructure\Persistence\InMemory\Domain\Entity\Tenant;

use Domain\Entity\Tenant\Tenant;
use Domain\Entity\Tenant\TenantRepository;

class InMemoryTenantRepository implements TenantRepository
{
    /**
     * @var Tenant[]
     */
    private $tenants;

    /**
     * @param Tenant[] $tenants
     */
    public function __construct($tenants)
    {
        $this->tenants = $tenants;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $aNullTenant = null;
        foreach ($this->tenants as $tenant) {
            if ($tenant->id() === $id) {
                return $tenant;
            }
        }

        return $aNullTenant;
    }
}
