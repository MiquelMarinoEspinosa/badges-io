<?php

namespace Interactor\CommandHandler\CreateBadge\Validator;

use Interactor\CommandHandler\CreateBadge\CreateBadgeCommand;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandException;
use Interactor\CommandHandler\CreateBadge\Exception\InvalidCreateBadgeCommandExceptionCode;
use Interactor\CommandHandler\CreateBadge\ImageData\Validator\ImageDataValidator;
use Interactor\CommandHandler\CreateBadge\UserData\Validator\UserDataValidator;
use Interactor\Validator\Validator;

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
             ->validateIsMultiUser()
             ->validateUserData()
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
    private function validateIsMultiUser()
    {
        $this->checkIsMultiUserNotNull()
              ->checkIsMultiUserFormat();

        return $this;
    }

    /**
     * @return CreateBadgeCommandValidator
     * @throws InvalidCreateBadgeCommandException
     */
    private function checkIsMultiUserNotNull()
    {
        $aNullIsMultiUser = null;
        if ($this->createBadgeCommand->isMultiUser() === $aNullIsMultiUser) {
            throw $this->buildInvalidCreateCommandException(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return CreateBadgeCommandValidator
     * @throws InvalidCreateBadgeCommandException
     */
    private function checkIsMultiUserFormat()
    {
        if ($this->notValidIsMultiUserFormat($this->createBadgeCommand->isMultiUser())) {
            throw $this->buildInvalidCreateCommandException(
                InvalidCreateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_VALID_PROVIDED
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
     * @return InvalidCreateBadgeCommandException
     */
    private function buildInvalidCreateCommandException($statusCode)
    {
        return new InvalidCreateBadgeCommandException($statusCode);
    }

    /**
     * @return CreateBadgeCommandValidator
     */
    private function validateUserData()
    {
        $this->buildUserDataValidator()->validate();

        return $this;
    }

    /**
     * @return UserDataValidator
     */
    private function buildUserDataValidator()
    {
        return new UserDataValidator($this->createBadgeCommand->userData());
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
