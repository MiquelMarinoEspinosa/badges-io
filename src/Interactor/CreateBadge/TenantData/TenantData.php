<?php

namespace Interactor\CreateBadge\TenantData;

class TenantData
{
    /** @var  string */
    private $id;

    public function __construct($tenantId)
    {
        $this->setId($tenantId);
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param string $tenantId
     *
     * @return TenantData
     */
    private function setId($tenantId)
    {
        $this->id = $tenantId;

        return $this;
    }
}
