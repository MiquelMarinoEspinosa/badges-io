<?php

namespace Domain\Entity\Badge;

use Domain\Entity\Badge\Validator\BadgeValidator;
use Domain\Entity\Image\Image;
use Domain\Entity\Tenant\Tenant;

class Badge
{
    /** @var  string */
    private $id;
    /** @var  string */
    private $name;
    /** @var  string */
    private $description;
    /** @var  bool */
    private $isMultiTenant;
    /** @var  Tenant[] */
    private $tenants;
    /** @var  Image */
    private $image;

    public function __construct($id, $name, $description, $isMultiTenant, $tenants, Image $image)
    {
        $this->setId($id)
             ->setName($name)
             ->setDescription($description)
             ->setIsMultiTenant($isMultiTenant)
             ->setTenants($tenants)
             ->setImage($image)
             ->validate();
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
     * @return Badge
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
     * @return Badge
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
     * @return Badge
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
     * @return Badge
     */
    private function setIsMultiTenant($isMultiTenant)
    {
        $this->isMultiTenant = $isMultiTenant;

        return $this;
    }

    /**
     * @return Tenant[]
     */
    public function tenants()
    {
        return $this->tenants;
    }

    /**
     * @param Tenant[] $tenants
     *
     * @return Badge
     */
    public function setTenants($tenants)
    {
        $this->tenants = $tenants;

        return $this;
    }

    /**
     * @return Image
     */
    public function image()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     *
     * @return Badge
     */
    private function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    private function validate()
    {
        $this->buildValidator()->validate();
    }

    /**
     * @return BadgeValidator
     */
    private function buildValidator()
    {
        return new BadgeValidator($this);
    }
}
