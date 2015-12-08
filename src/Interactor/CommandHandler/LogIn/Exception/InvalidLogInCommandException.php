<?php

namespace Interactor\CommandHandler\LogIn\Exception;

use Interactor\Exception\BaseException;

class InvalidLogInCommandException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidLogInCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED:
                $this->userIdNotProvided();
                break;
            case InvalidLogInCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED:
                $this->userIdNotValidProvided();
                break;
            case InvalidLogInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED:
                $this->passWordNotProvided();
                break;
            case InvalidLogInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED:
                $this->passWordNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidLogInCommandException
     */
    private function userIdNotProvided()
    {
        $this->setCode(InvalidLogInCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED)
             ->setMessage(InvalidLogInCommandExceptionCode::MESSAGE_CODE_USER_ID_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidLogInCommandException
     */
    private function userIdNotValidProvided()
    {
        $this->setCode(InvalidLogInCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED)
             ->setMessage(InvalidLogInCommandExceptionCode::MESSAGE_CODE_USER_ID_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidLogInCommandException
     */
    private function passWordNotProvided()
    {
        $this->setCode(InvalidLogInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED)
             ->setMessage(InvalidLogInCommandExceptionCode::MESSAGE_CODE_PASSWORD_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidLogInCommandException
     */
    private function passWordNotValidProvided()
    {
        $this->setCode(InvalidLogInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED)
            ->setMessage(InvalidLogInCommandExceptionCode::MESSAGE_CODE_PASSWORD_NOT_VALID_PROVIDED);

        return $this;
    }
}
