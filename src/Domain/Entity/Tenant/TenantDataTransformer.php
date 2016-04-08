<?php

namespace Domain\Entity\Tenant;

interface TenantDataTransformer
{
    /**
     * @param Tenant $tenant
     *
     * @return mixed
     */
    public function transform(Tenant $tenant);
}
