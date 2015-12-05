<?php

namespace Interactor\CreateBadge\Validator;

use Interactor\CreateBadge\CreateBadgeCommand;
use Interactor\CreateBadge\Exception\InvalidCreateBadgeCommandException;
use Interactor\CreateBadge\Exception\InvalidCreateBadgeCommandExceptionCode;
use Interactor\CreateBadge\ImageData\Validator\ImageDataValidator;
use Interactor\CreateBadge\TenantData\Validator\TenantDataValidator;
use Validator\Validator;

class CreateBadgeCommandValidator implements Validator
{
    /**
     * @var CreateBadgeCommand
     */
    private $createBadgeCommand;

    public function __construct(CreateBadgeCommand $createBadgeCommand)
    {
        $this->createBadgeCommand = $createBadgeCommand;
    }

    public function validate()
    {
        $this->validateName()
             ->validateDescription()
             ->validateIsMultitenant()
             ->validateTenantData()
             ->validateImageData();
    }

    /**
     * @return CreateBadgeCommandValidator
     * @throws InvalidCreateBadgeCommandException
     */
    private function validateName()
    {
        $this->checkNameNotNull()
             ->checkNameFormat();

        return $this;
    }

    /**
     * @return CreateBadgeCommandValidator
     * @throws InvalidCreateBadgeCommandException
     */
    private function checkNameNotNull()
    {
        $aNullName = null;
        if ($this->createBadgeCommand->name() === $aNullName) {
            throw $this->buildInvalidCreateCommandException(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return CreateBadgeCommandValidator
     * @throws InvalidCreateBadgeCommandException
     */
    private function checkNameFormat()
    {
        if ($this->notValidNameFormat($this->createBadgeCommand->name())) {
            throw $this->buildInvalidCreateCommandException(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    private function notValidNameFormat($name)
    {
        return !is_string($name) || '' === trim($name);
    }

    /**
     * @return CreateBadgeCommandValidator
     * @throws InvalidCreateBadgeCommandException
     */
    private function validateDescription()
    {
        $this->checkDescriptionNotNull()
             ->checkDescriptionFormat();

        return $this;
    }

    /**
     * @return CreateBadgeCommandValidator
     * @throws InvalidCreateBadgeCommandException
     */
    private function checkDescriptionNotNull()
    {
        $aNullDescription = null;
        if ($this->createBadgeCommand->description() === $aNullDescription) {
            throw $this->buildInvalidCreateCommandException(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return CreateBadgeCommandValidator
     * @throws InvalidCreateBadgeCommandException
     */
    private function checkDescriptionFormat()
    {
        if ($this->notValidDescriptionFormat($this->createBadgeCommand->description())) {
            throw $this->buildInvalidCreateCommandException(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $description
     *
     * @return bool
     */
    private function notValidDescriptionFormat($description)
    {
        return !is_string($description);
    }

    /**
     * @return CreateBadgeCommandValidator
     * @throws InvalidCreateBadgeCommandException
     */
    private function validateIsMultiTenant()
    {
        $this->checkIsMultiTenantNotNull()
              ->checkIsMultiTenantFormat();

        return $this;
    }

    /**
     * @return CreateBadgeCommandValidator
     * @throws InvalidCreateBadgeCommandException
     */
    private function checkIsMultiTenantFormat()
    {
        if ($this->notValidIsMultiTenantFormat($this->createBadgeCommand->isMultiTenant())) {
            throw $this->buildInvalidCreateCommandException(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $isMultiTenant
     *
     * @return bool
     */
    private function notValidIsMultiTenantFormat($isMultiTenant)
    {
        return !is_bool($isMultiTenant);
    }

    /**
     * @return CreateBadgeCommandValidator
     * @throws InvalidCreateBadgeCommandException
     */
    private function checkIsMultiTenantNotNull()
    {
        $aNullIsMultiTenant = null;
        if ($this->createBadgeCommand->isMultiTenant() === $aNullIsMultiTenant) {
            throw $this->buildInvalidCreateCommandException(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidCreateBadgeCommandException
     */
    private function buildInvalidCreateCommandException($statusCode)
    {
        return new InvalidCreateBadgeCommandException($statusCode);
    }

    /**
     * @return CreateBadgeCommandValidator
     */
    private function validateTenantData()
    {
        $this->buildTenantDataValidator()->validate();

        return $this;
    }

    /**
     * @return TenantDataValidator
     */
    private function buildTenantDataValidator()
    {
        return new TenantDataValidator($this->createBadgeCommand->tenantData());
    }

    /**
     * @return CreateBadgeCommandValidator
     */
    private function validateImageData()
    {
        $this->buildImageDataValidator()->validate();

        return $this;
    }

    /**
     * @return ImageDataValidator
     */
    private function buildImageDataValidator()
    {
        return new ImageDataValidator($this->createBadgeCommand->imageData());
    }
}
