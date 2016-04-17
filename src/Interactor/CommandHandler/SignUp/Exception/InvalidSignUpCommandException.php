<?php

namespace Interactor\CommandHandler\SignUp\Exception;

use Interactor\Exception\BaseException;

class InvalidSignUpCommandException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidSignUpCommandExceptionCode::STATUS_CODE_EMAIL_NOT_PROVIDED:
                $this->emailNotProvided();
                break;
            case InvalidSignUpCommandExceptionCode::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED:
                $this->emailNotValidProvided();
                break;
            case InvalidSignUpCommandExceptionCode::STATUS_CODE_USERNAME_NOT_PROVIDED:
                $this->userNameNotProvided();
                break;
            case InvalidSignUpCommandExceptionCode::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED:
                $this->userNameNotValidProvided();
                break;
            case InvalidSignUpCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED:
                $this->passWordNotProvided();
                break;
            case InvalidSignUpCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED:
                $this->passWordNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidSignUpCommandException
     */
    private function emailNotProvided()
    {
        $this->setCode(InvalidSignUpCommandExceptionCode::STATUS_CODE_EMAIL_NOT_PROVIDED)
             ->setMessage(InvalidSignUpCommandExceptionCode::MESSAGE_CODE_EMAIL_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignUpCommandException
     */
    private function emailNotValidProvided()
    {
        $this->setCode(InvalidSignUpCommandExceptionCode::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED)
             ->setMessage(InvalidSignUpCommandExceptionCode::MESSAGE_CODE_EMAIL_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignUpCommandException
     */
    private function userNameNotProvided()
    {
        $this->setCode(InvalidSignUpCommandExceptionCode::STATUS_CODE_USERNAME_NOT_PROVIDED)
             ->setMessage(InvalidSignUpCommandExceptionCode::MESSAGE_CODE_USERNAME_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignUpCommandException
     */
    private function userNameNotValidProvided()
    {
        $this->setCode(InvalidSignUpCommandExceptionCode::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED)
             ->setMessage(InvalidSignUpCommandExceptionCode::MESSAGE_CODE_USERNAME_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignUpCommandException
     */
    private function passWordNotProvided()
    {
        $this->setCode(InvalidSignUpCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED)
             ->setMessage(InvalidSignUpCommandExceptionCode::MESSAGE_CODE_PASSWORD_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignUpCommandException
     */
    private function passWordNotValidProvided()
    {
        $this->setCode(InvalidSignUpCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED)
             ->setMessage(InvalidSignUpCommandExceptionCode::MESSAGE_CODE_PASSWORD_NOT_VALID_PROVIDED);

        return $this;
    }
}
