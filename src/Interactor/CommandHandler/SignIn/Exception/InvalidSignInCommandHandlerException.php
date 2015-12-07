<?php

namespace Interactor\CommandHandler\SignIn\Exception;

use Interactor\Exception\BaseException;

class InvalidSignInCommandHandlerException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED:
                $this->userNotCreated();
                break;
            case InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_EMAIL_ALREADY_EXISTS:
                $this->emailAlreadyExists();
                break;
            case InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_USERNAME_ALREADY_EXISTS:
                $this->userNameAlreadyExists();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidSignInCommandHandlerException
     */
    private function userNotCreated()
    {
        $this->setCode(InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_CREATED)
            ->setMessage(InvalidSignInCommandHandlerExceptionCode::MESSAGE_CODE_USER_NOT_CREATED);

        return $this;
    }

    /**
     * @return InvalidSignInCommandHandlerException
     */
    private function emailAlreadyExists()
    {
        $this->setCode(InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_EMAIL_ALREADY_EXISTS)
             ->setMessage(InvalidSignInCommandHandlerExceptionCode::MESSAGE_CODE_EMAIL_ALREADY_EXISTS);

        return $this;
    }

    /**
     * @return InvalidSignInCommandHandlerException
     */
    private function userNameAlreadyExists()
    {
        $this->setCode(InvalidSignInCommandHandlerExceptionCode::STATUS_CODE_USERNAME_ALREADY_EXISTS)
             ->setMessage(InvalidSignInCommandHandlerExceptionCode::MESSAGE_CODE_USERNAME_ALREADY_EXISTS);

        return $this;
    }
}
