<?php

namespace Domain\Entity\Badge\Validator;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\Exception\InvalidBadgeException;
use Domain\Entity\Badge\Exception\InvalidBadgeExceptionCode;
use Domain\Entity\Tenant\Tenant;
use Domain\Validator\Validator;

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
             ->validateIsMultitenant();
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
     * @param int $statusCode
     *
     * @return InvalidBadgeException
     */
    private function buildInvalidCreateCommandException($statusCode)
    {
        return new InvalidBadgeException($statusCode);
    }
}
