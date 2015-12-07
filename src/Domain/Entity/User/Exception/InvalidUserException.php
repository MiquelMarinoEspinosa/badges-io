<?php

namespace Domain\Entity\User\Exception;

use Domain\Exception\BaseException;

class InvalidUserException extends BaseException
{
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidUserExceptionCode::STATUS_CODE_ID_NOT_PROVIDED:
                $this->idNotProvided();
                break;
            case InvalidUserExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED:
                $this->idNotValidProvided();
                break;
            case InvalidUserExceptionCode::STATUS_CODE_EMAIL_NOT_PROVIDED:
                $this->emailNotProvided();
                break;
            case InvalidUserExceptionCode::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED:
                $this->emailNotValidProvided();
                break;
            case InvalidUserExceptionCode::STATUS_CODE_USERNAME_NOT_PROVIDED:
                $this->userNameNotProvided();
                break;
            case InvalidUserExceptionCode::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED:
                $this->userNameNotValidProvided();
                break;
            case InvalidUserExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED:
                $this->passWordNotProvided();
                break;
            case InvalidUserExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED:
                $this->passWordNotValidProvided();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidUserException
     */
    private function idNotProvided()
    {
        $this->setCode(InvalidUserExceptionCode::STATUS_CODE_ID_NOT_PROVIDED)
             ->setMessage(InvalidUserExceptionCode::MESSAGE_CODE_ID_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUserException
     */
    private function idNotValidProvided()
    {
        $this->setCode(InvalidUserExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED)
             ->setMessage(InvalidUserExceptionCode::MESSAGE_CODE_ID_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUserException
     */
    private function emailNotProvided()
    {
        $this->setCode(InvalidUserExceptionCode::STATUS_CODE_EMAIL_NOT_PROVIDED)
             ->setMessage(InvalidUserExceptionCode::MESSAGE_CODE_EMAIL_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUserException
     */
    private function emailNotValidProvided()
    {
        $this->setCode(InvalidUserExceptionCode::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED)
             ->setMessage(InvalidUserExceptionCode::MESSAGE_CODE_EMAIL_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUserException
     */
    private function userNameNotProvided()
    {
        $this->setCode(InvalidUserExceptionCode::STATUS_CODE_USERNAME_NOT_PROVIDED)
             ->setMessage(InvalidUserExceptionCode::MESSAGE_CODE_USERNAME_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUserException
     */
    private function userNameNotValidProvided()
    {
        $this->setCode(InvalidUserExceptionCode::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED)
             ->setMessage(InvalidUserExceptionCode::MESSAGE_CODE_USERNAME_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUserException
     */
    private function passWordNotProvided()
    {
        $this->setCode(InvalidUserExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED)
             ->setMessage(InvalidUserExceptionCode::MESSAGE_CODE_PASSWORD_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidUserException
     */
    private function passWordNotValidProvided()
    {
        $this->setCode(InvalidUserExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED)
             ->setMessage(InvalidUserExceptionCode::MESSAGE_CODE_PASSWORD_NOT_VALID_PROVIDED);

        return $this;
    }
}
