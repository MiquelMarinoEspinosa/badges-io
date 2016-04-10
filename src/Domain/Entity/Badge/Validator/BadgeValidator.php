<?php

namespace Domain\Entity\Badge\Validator;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\Exception\InvalidBadgeException;
use Domain\Entity\Badge\Exception\InvalidBadgeExceptionCode;
use Domain\Entity\User\User;
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
             ->validateIsMultiUser();
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
    private function validateIsMultiUser()
    {
        $this->checkIsMultiUserNotNull()
             ->checkIsMultiUserFormat();

        return $this;
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function checkIsMultiUserNotNull()
    {
        $aNullIsMultiUser = null;
        if ($this->badge->isMultiUser() === $aNullIsMultiUser) {
            throw $this->buildInvalidCreateCommandException(
                InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return BadgeValidator
     * @throws InvalidBadgeException
     */
    private function checkIsMultiUserFormat()
    {
        if ($this->notValidIsMultiUserFormat($this->badge->isMultiUser())) {
            throw $this->buildInvalidCreateCommandException(
                InvalidBadgeExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $isMultiUser
     *
     * @return bool
     */
    private function notValidIsMultiUserFormat($isMultiUser)
    {
        return !is_bool($isMultiUser);
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
