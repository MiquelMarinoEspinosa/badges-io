<?php

namespace Interactor\SignIn\Exception;

use Exception\BaseException;

class InvalidSignInCommandHandlerException extends BaseException
{
    const STATUS_CODE_EMAIL_ALREADY_EXISTS      = -1;
    const MESSAGE_CODE_EMAIL_ALREADY_EXISTS     = 'Email already exists';
    const STATUS_CODE_USERNAME_ALREADY_EXISTS   = -2;
    const MESSAGE_CODE_USERNAME_ALREADY_EXISTS  = 'Username already exists';

    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case static::STATUS_CODE_EMAIL_ALREADY_EXISTS:
                $this->emailAlreadyExists();
                break;
            case static::STATUS_CODE_USERNAME_ALREADY_EXISTS:
                $this->userNameAlreadyExists();
                break;
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidSignInCommandHandlerException
     */
    private function emailAlreadyExists()
    {
        $this->setCode(static::STATUS_CODE_EMAIL_ALREADY_EXISTS)
             ->setMessage(static::MESSAGE_CODE_EMAIL_ALREADY_EXISTS);

        return $this;
    }

    /**
     * @return InvalidSignInCommandHandlerException
     */
    private function userNameAlreadyExists()
    {
        $this->setCode(static::STATUS_CODE_USERNAME_ALREADY_EXISTS)
             ->setMessage(static::MESSAGE_CODE_USERNAME_ALREADY_EXISTS);

        return $this;
    }
}
