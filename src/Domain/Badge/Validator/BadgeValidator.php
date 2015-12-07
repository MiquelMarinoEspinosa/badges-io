<?php

namespace Domain\Badge\Validator;

use Domain\Badge\Badge;
use Domain\Badge\Exception\InvalidBadgeException;
use Domain\Badge\Exception\InvalidBadgeExceptionCode;
use Domain\Tenant\Tenant;
use Validator\Validator;

class BadgeValidator implements Validator
{
    /**
     * @var Badge
     */
    private $badge;

    public function __construct(Badge $createBadgeCommand)
    {
        $this->badge = $createBadgeCommand;
    }

    public function validate()
    {
        $this->validateId()
             ->validateName()
             ->validateDescription()
             ->validateIsMultitenant()
             ->validateTenants();
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function validateId()
    {
        $this->checkIdNotNull()
             ->checkIdFormat();

        return $this;
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function checkIdNotNull()
    {
        $aNullId = null;
        if ($this->badge->id() === $aNullId) {
            throw $this->buildInvalidCreateCommandException(
                InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function checkIdFormat()
    {
        if ($this->notValidIdFormat($this->badge->id())) {
            throw $this->buildInvalidCreateCommandException(
                InvalidBadgeExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    private function notValidIdFormat($id)
    {
        return !is_string($id) || '' === trim($id);
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function validateName()
    {
        $this->checkNameNotNull()
             ->checkNameFormat();

        return $this;
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function checkNameNotNull()
    {
        $aNullName = null;
        if ($this->badge->name() === $aNullName) {
            throw $this->buildInvalidCreateCommandException(
                InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function checkNameFormat()
    {
        if ($this->notValidNameFormat($this->badge->name())) {
            throw $this->buildInvalidCreateCommandException(
                InvalidBadgeExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED
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
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function validateDescription()
    {
        $this->checkDescriptionNotNull()
             ->checkDescriptionFormat();

        return $this;
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function checkDescriptionNotNull()
    {
        $aNullDescription = null;
        if ($this->badge->description() === $aNullDescription) {
            throw $this->buildInvalidCreateCommandException(
                InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function checkDescriptionFormat()
    {
        if ($this->notValidDescriptionFormat($this->badge->description())) {
            throw $this->buildInvalidCreateCommandException(
                InvalidBadgeExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED
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
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function validateIsMultiTenant()
    {
        $this->checkIsMultiTenantNotNull()
             ->checkIsMultiTenantFormat();

        return $this;
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function checkIsMultiTenantNotNull()
    {
        $aNullIsMultiTenant = null;
        if ($this->badge->isMultiTenant() === $aNullIsMultiTenant) {
            throw $this->buildInvalidCreateCommandException(
                InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function checkIsMultiTenantFormat()
    {
        if ($this->notValidIsMultiTenantFormat($this->badge->isMultiTenant())) {
            throw $this->buildInvalidCreateCommandException(
                InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_TENANT_NOT_VALID_PROVIDED
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
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function validateTenants()
    {
        $this->checkIsTenantsNotNull()
             ->checkTenantsFormat();

        return $this;
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function checkIsTenantsNotNull()
    {
        $aNullTenants = null;
        if ($this->badge->tenants() === $aNullTenants) {
            throw $this->buildInvalidCreateCommandException(
                InvalidBadgeExceptionCode::STATUS_CODE_TENANTS_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function checkTenantsFormat()
    {
        if ($this->notValidTenantsFormat($this->badge->tenants())) {
            throw $this->buildInvalidCreateCommandException(
                InvalidBadgeExceptionCode::STATUS_CODE_TENANTS_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param Tenant[] $tenants
     *
     * @return bool
     */
    private function notValidTenantsFormat($tenants)
    {
        $notValidFormat = true;
        $validFormat    = false;

        if (!is_array($tenants)) {
            return $notValidFormat;
        }

        if (!$this->badge->isMultiTenant() && count($tenants) > 1) {
            return $notValidFormat;
        }

        foreach ($tenants as $tenant) {
            if ($this->isNotATenant($tenant)) {
                return $notValidFormat;
            }
        }

        return $validFormat;
    }

    /**
     * @param mixed $object
     *
     * @return bool
     */
    private function isNotATenant($object)
    {
        return !($object instanceof Tenant);
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidBadgeException
     */
    private function buildInvalidCreateCommandException($statusCode)
    {
        return new InvalidBadgeException($statusCode);
    }
}
