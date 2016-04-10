<?php

namespace Interactor\CommandHandler\UpdateBadge\Validator;

use Interactor\CommandHandler\UpdateBadge\UpdateBadgeCommand;
use Interactor\CommandHandler\UpdateBadge\Exception\InvalidUpdateBadgeCommandException;
use Interactor\CommandHandler\UpdateBadge\Exception\InvalidUpdateBadgeCommandExceptionCode;
use Interactor\CommandHandler\UpdateBadge\ImageData\Validator\ImageDataValidator;
use Interactor\CommandHandler\UpdateBadge\UserData\Validator\UserDataValidator;
use Interactor\Validator\Validator;

class UpdateBadgeCommandValidator implements Validator
{
    /**
     * @var UpdateBadgeCommand
     */
    private $updateBadgeCommand;

    public function __construct(UpdateBadgeCommand $updateBadgeCommand)
    {
        $this->updateBadgeCommand = $updateBadgeCommand;
    }

    public function validate()
    {
        $this->validateId()
             ->validateName()
             ->validateDescription()
             ->validateIsMultiUser()
             ->validateUserData()
             ->validateImageData();
    }

    /**
     * @return UpdateBadgeCommandValidator
     * @throws InvalidUpdateBadgeCommandException
     */
    private function validateId()
    {
        $this->checkIdNotNull()
             ->checkIdFormat();

        return $this;
    }

    /**
     * @return UpdateBadgeCommandValidator
     * @throws InvalidUpdateBadgeCommandException
     */
    private function checkIdNotNull()
    {
        $aNullId = null;
        if ($this->updateBadgeCommand->id() === $aNullId) {
            throw $this->buildInvalidUpdateCommandException(
                InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_ID_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return UpdateBadgeCommandValidator
     * @throws InvalidUpdateBadgeCommandException
     */
    private function checkIdFormat()
    {
        if ($this->notValidIdFormat($this->updateBadgeCommand->id())) {
            throw $this->buildInvalidUpdateCommandException(
                InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED
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
     * @return UpdateBadgeCommandValidator
     * @throws InvalidUpdateBadgeCommandException
     */
    private function validateName()
    {
        $this->checkNameNotNull()
             ->checkNameFormat();

        return $this;
    }

    /**
     * @return UpdateBadgeCommandValidator
     * @throws InvalidUpdateBadgeCommandException
     */
    private function checkNameNotNull()
    {
        $aNullName = null;
        if ($this->updateBadgeCommand->name() === $aNullName) {
            throw $this->buildInvalidUpdateCommandException(
                InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return UpdateBadgeCommandValidator
     * @throws InvalidUpdateBadgeCommandException
     */
    private function checkNameFormat()
    {
        if ($this->notValidNameFormat($this->updateBadgeCommand->name())) {
            throw $this->buildInvalidUpdateCommandException(
                InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_NAME_NOT_VALID_PROVIDED
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
     * @return UpdateBadgeCommandValidator
     * @throws InvalidUpdateBadgeCommandException
     */
    private function validateDescription()
    {
        $this->checkDescriptionNotNull()
             ->checkDescriptionFormat();

        return $this;
    }

    /**
     * @return UpdateBadgeCommandValidator
     * @throws InvalidUpdateBadgeCommandException
     */
    private function checkDescriptionNotNull()
    {
        $aNullDescription = null;
        if ($this->updateBadgeCommand->description() === $aNullDescription) {
            throw $this->buildInvalidUpdateCommandException(
                InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return UpdateBadgeCommandValidator
     * @throws InvalidUpdateBadgeCommandException
     */
    private function checkDescriptionFormat()
    {
        if ($this->notValidDescriptionFormat($this->updateBadgeCommand->description())) {
            throw $this->buildInvalidUpdateCommandException(
                InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_DESCRIPTION_NOT_VALID_PROVIDED
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
     * @return UpdateBadgeCommandValidator
     * @throws InvalidUpdateBadgeCommandException
     */
    private function validateIsMultiUser()
    {
        $this->checkIsMultiUserNotNull()
             ->checkIsMultiUserFormat();

        return $this;
    }

    /**
     * @return UpdateBadgeCommandValidator
     * @throws InvalidUpdateBadgeCommandException
     */
    private function checkIsMultiUserNotNull()
    {
        $aNullIsMultiUser = null;
        if ($this->updateBadgeCommand->isMultiUser() === $aNullIsMultiUser) {
            throw $this->buildInvalidUpdateCommandException(
                InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return UpdateBadgeCommandValidator
     * @throws InvalidUpdateBadgeCommandException
     */
    private function checkIsMultiUserFormat()
    {
        if ($this->notValidIsMultiUserFormat($this->updateBadgeCommand->isMultiUser())) {
            throw $this->buildInvalidUpdateCommandException(
                InvalidUpdateBadgeCommandExceptionCode::STATUS_CODE_IS_MULTI_USER_NOT_VALID_PROVIDED
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
     * @return InvalidUpdateBadgeCommandException
     */
    private function buildInvalidUpdateCommandException($statusCode)
    {
        return new InvalidUpdateBadgeCommandException($statusCode);
    }

    /**
     * @return UpdateBadgeCommandValidator
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
        return new UserDataValidator($this->updateBadgeCommand->userData());
    }

    /**
     * @return UpdateBadgeCommandValidator
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
        return new ImageDataValidator($this->updateBadgeCommand->imageData());
    }
}
