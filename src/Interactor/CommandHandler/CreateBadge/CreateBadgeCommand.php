<?php

namespace Interactor\CommandHandler\CreateBadge;

use Interactor\CommandHandler\Command;
use Interactor\CommandHandler\CreateBadge\ImageData\ImageData;
use Interactor\CommandHandler\CreateBadge\TenantData\TenantData;
use Interactor\CommandHandler\CreateBadge\Validator\CreateBadgeCommandValidator;

class CreateBadgeCommand implements Command
{
    /** @var  string */
    private $name;
    /** @var  string */
    private $description;
    /** @var  bool */
    private $isMultiTenant;
    /** @var  TenantData */
    private $tenantData;
    /** @var  ImageData */
    private $imageData;

    public function __construct($name, $description, $isMultiTenant, TenantData $tenantData, ImageData $imageData)
    {
        $this->setName($name)
             ->setDescription($description)
             ->setIsMultiTenant($isMultiTenant)
             ->setTenantData($tenantData)
             ->setImageData($imageData)
             ->validate();
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
     * @return CreateBadgeCommand
     */
    public function setName($name)
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
     * @return CreateBadgeCommand
     */
    private function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return TenantData
     */
    public function tenantData()
    {
        return $this->tenantData;
    }

    /**
     * @param TenantData $tenantData
     *
     * @return CreateBadgeCommand
     */
    private function setTenantData($tenantData)
    {
        $this->tenantData = $tenantData;

        return $this;
    }

    /**
     * @return ImageData
     */
    public function imageData()
    {
        return $this->imageData;
    }

    /**
     * @param ImageData $imageData
     *
     * @return CreateBadgeCommand
     */
    private function setImageData($imageData)
    {
        $this->imageData = $imageData;

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
     * @return CreateBadgeCommand
     */
    private function setIsMultiTenant($isMultiTenant)
    {
        $this->isMultiTenant = $isMultiTenant;

        return $this;
    }

    /**
     * @return CreateBadgeCommand
     */
    private function validate()
    {
        $this->buildValidator()->validate();

        return $this;
    }

    /**
     * @return CreateBadgeCommandValidator
     */
    private function buildValidator()
    {
        return new CreateBadgeCommandValidator($this);
    }
}
