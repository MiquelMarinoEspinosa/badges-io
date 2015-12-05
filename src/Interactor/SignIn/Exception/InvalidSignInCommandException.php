<?php

namespace Interactor\SignIn\Exception;

use Exception\BaseException;

class InvalidSignInCommandException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidSignInCommandExceptionCode::STATUS_CODE_EMAIL_NOT_PROVIDED:
                $this->emailNotProvided();
                break;
            case InvalidSignInCommandExceptionCode::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED:
                $this->emailNotValidProvided();
                break;
            case InvalidSignInCommandExceptionCode::STATUS_CODE_USERNAME_NOT_PROVIDED:
                $this->userNameNotProvided();
                break;
            case InvalidSignInCommandExceptionCode::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED:
                $this->userNameNotValidProvided();
                break;
            case InvalidSignInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED:
                $this->passWordNotProvided();
                break;
            case InvalidSignInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED:
                $this->passWordNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidSignInCommandException
     */
    private function emailNotProvided()
    {
        $this->setCode(InvalidSignInCommandExceptionCode::STATUS_CODE_EMAIL_NOT_PROVIDED)
             ->setMessage(InvalidSignInCommandExceptionCode::MESSAGE_CODE_EMAIL_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignInCommandException
     */
    private function emailNotValidProvided()
    {
        $this->setCode(InvalidSignInCommandExceptionCode::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED)
             ->setMessage(InvalidSignInCommandExceptionCode::MESSAGE_CODE_EMAIL_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignInCommandException
     */
    private function userNameNotProvided()
    {
        $this->setCode(InvalidSignInCommandExceptionCode::STATUS_CODE_USERNAME_NOT_PROVIDED)
             ->setMessage(InvalidSignInCommandExceptionCode::MESSAGE_CODE_USERNAME_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignInCommandException
     */
    private function userNameNotValidProvided()
    {
        $this->setCode(InvalidSignInCommandExceptionCode::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED)
             ->setMessage(InvalidSignInCommandExceptionCode::MESSAGE_CODE_USERNAME_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignInCommandException
     */
    private function passWordNotProvided()
    {
        $this->setCode(InvalidSignInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED)
             ->setMessage(InvalidSignInCommandExceptionCode::MESSAGE_CODE_PASSWORD_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignInCommandException
     */
    private function passWordNotValidProvided()
    {
        $this->setCode(InvalidSignInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED)
             ->setMessage(InvalidSignInCommandExceptionCode::MESSAGE_CODE_PASSWORD_NOT_VALID_PROVIDED);

        return $this;
    }
}
