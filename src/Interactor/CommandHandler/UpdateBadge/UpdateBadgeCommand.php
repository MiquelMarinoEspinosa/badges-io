<?php

namespace Interactor\CommandHandler\UpdateBadge;

use Interactor\CommandHandler\BaseCommand;
use Interactor\CommandHandler\UpdateBadge\ImageData\ImageData;
use Interactor\CommandHandler\UpdateBadge\TenantData\TenantData;
use Interactor\CommandHandler\UpdateBadge\Validator\UpdateBadgeCommandValidator;

class UpdateBadgeCommand extends BaseCommand
{
    /** @var  string */
    private $id;
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

    public function __construct($id, $name, $description, $isMultiTenant, TenantData $tenantData, ImageData $imageData)
    {
        $this->setId($id)
             ->setName($name)
             ->setDescription($description)
             ->setIsMultiTenant($isMultiTenant)
             ->setTenantData($tenantData)
             ->setImageData($imageData)
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
     * @return UpdateBadgeCommand
     */
    public function setId($id)
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
     * @return UpdateBadgeCommand
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
     * @return UpdateBadgeCommand
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
     * @return UpdateBadgeCommand
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
     * @return UpdateBadgeCommand
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
     * @return UpdateBadgeCommand
     */
    private function setIsMultiTenant($isMultiTenant)
    {
        $this->isMultiTenant = $isMultiTenant;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function buildValidator()
    {
        return new UpdateBadgeCommandValidator($this);
    }
}
