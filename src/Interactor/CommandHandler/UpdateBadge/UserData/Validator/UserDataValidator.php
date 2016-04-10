<?php

namespace Interactor\CommandHandler\UpdateBadge\UserData\Validator;

use Interactor\CommandHandler\UpdateBadge\UserData\Exception\InvalidUserDataException;
use Interactor\CommandHandler\UpdateBadge\UserData\Exception\InvalidUserDataExceptionCode;
use Interactor\CommandHandler\UpdateBadge\UserData\UserData;
use Interactor\Validator\Validator;

class UserDataValidator implements Validator
{
    /**
     * @var UserData
     */
    private $userData;

    public function __construct(UserData $userData)
    {
        $this->userData = $userData;
    }

    public function validate()
    {
        $this->validateId();
    }

    /**
     * @throws InvalidUserDataException
     */
    private function validateId()
    {
        $this->checkIdIsNotNull()
             ->checkIdFormat();
    }

    /**
     * @return UserDataValidator
     * @throws InvalidUserDataException
     */
    private function checkIdIsNotNull()
    {
        $aNullId = null;
        if ($this->userData->id() === $aNullId) {
            throw $this->buildInvalidTenantDataException(InvalidUserDataExceptionCode::STATUS_CODE_ID_NOT_PROVIDED);
        }

        return $this;
    }

    /**
     * @return UserDataValidator
     * @throws InvalidUserDataException
     */
    private function checkIdFormat()
    {
        if ($this->noValidIdFormat($this->userData->id())) {
            throw $this->buildInvalidTenantDataException(
                InvalidUserDataExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    private function noValidIdFormat($id)
    {
        return !is_string($id) || '' === trim($id);
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidUserDataException
     */
    private function buildInvalidTenantDataException($statusCode)
    {
        return new InvalidUserDataException($statusCode);
    }
}
