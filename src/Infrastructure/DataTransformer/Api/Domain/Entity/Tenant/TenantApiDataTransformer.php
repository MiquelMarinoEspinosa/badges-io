<?php

namespace Infrastructure\DataTransformer\Api\Domain\Entity\Tenant;

use Domain\Entity\Tenant\Tenant;
use Domain\Entity\Tenant\TenantDataTransformer;
use Infrastructure\Resource\Api\Domain\Entity\Tenant\TenantApiResource;

class TenantApiDataTransformer implements TenantDataTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform(Tenant $tenant)
    {
        return new TenantApiResource(
            $tenant->id(),
            $tenant->email(),
            $tenant->userName(),
            $tenant->passWord()
        );
    }
}
