<?php

namespace Infrastructure\Resource\Api\Domain\Entity\Badge;

use Infrastructure\Resource\Api\Domain\Entity\Image\ImageApiResource;
use Infrastructure\Resource\Api\Domain\Entity\Tenant\TenantApiResource;

class BadgeApiResource
{
    /** @var  string */
    private $id;
    /** @var  string */
    private $name;
    /** @var  string */
    private $description;
    /** @var  bool */
    private $isMultiTenant;
    /** @var TenantApiResource */
    private $tenantResource;
    /** @var ImageApiResource */
    private $imageResource;

    public function __construct(
        $id,
        $name,
        $description,
        $isMultiTenant,
        TenantApiResource $tenantResource,
        ImageApiResource $imageResource
    ) {
        $this->setId($id)
             ->setName($name)
             ->setDescription($description)
             ->setIsMultiTenant($isMultiTenant)
             ->setTenantResource($tenantResource)
             ->setImageResource($imageResource);
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return BadgeApiResource
     */
    private function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return BadgeApiResource
     */
    private function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return BadgeApiResource
     */
    private function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isMultiTenant()
    {
        return $this->isMultiTenant;
    }

    /**
     * @param boolean $isMultiTenant
     *
     * @return BadgeApiResource
     */
    private function setIsMultiTenant($isMultiTenant)
    {
        $this->isMultiTenant = $isMultiTenant;

        return $this;
    }

    /**
     * @return TenantApiResource
     */
    public function tenantResource()
    {
        return $this->tenantResource;
    }

    /**
     * @param TenantApiResource $tenantResource
     *
     * @return BadgeApiResource
     */
    private function setTenantResource(TenantApiResource $tenantResource)
    {
        $this->tenantResource = $tenantResource;

        return $this;
    }

    /**
     * @return ImageApiResource
     */
    public function imageResource()
    {
        return $this->imageResource;
    }

    /**
     * @param ImageApiResource $imageResource
     *
     * @return BadgeApiResource
     */
    private function setImageResource(ImageApiResource $imageResource)
    {
        $this->imageResource = $imageResource;

        return $this;
    }
}
