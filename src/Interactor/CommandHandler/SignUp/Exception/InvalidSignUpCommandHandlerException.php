<?php

namespace Interactor\CommandHandler\SignUp\Exception;

use Interactor\Exception\BaseException;

class InvalidSignUpCommandHandlerException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED:
                $this->userNotCreated();
                break;
            case InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_EMAIL_ALREADY_EXISTS:
                $this->emailAlreadyExists();
                break;
            case InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_USERNAME_ALREADY_EXISTS:
                $this->userNameAlreadyExists();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidSignUpCommandHandlerException
     */
    private function userNotCreated()
    {
        $this->setCode(InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED)
            ->setMessage(InvalidSignUpCommandHandlerExceptionCode::MESSAGE_CODE_USER_NOT_CREATED);

        return $this;
    }

    /**
     * @return InvalidSignUpCommandHandlerException
     */
    private function emailAlreadyExists()
    {
        $this->setCode(InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_EMAIL_ALREADY_EXISTS)
             ->setMessage(InvalidSignUpCommandHandlerExceptionCode::MESSAGE_CODE_EMAIL_ALREADY_EXISTS);

        return $this;
    }

    /**
     * @return InvalidSignUpCommandHandlerException
     */
    private function userNameAlreadyExists()
    {
        $this->setCode(InvalidSignUpCommandHandlerExceptionCode::STATUS_CODE_USERNAME_ALREADY_EXISTS)
             ->setMessage(InvalidSignUpCommandHandlerExceptionCode::MESSAGE_CODE_USERNAME_ALREADY_EXISTS);

        return $this;
    }
}
