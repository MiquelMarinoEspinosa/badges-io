<?php

namespace Interactor\CommandHandler\LogIn\Exception;

use Interactor\Exception\BaseException;

class InvalidLoginCommandHandlerException extends BaseException
{
    /**
     * @param int $statusCode
     */
    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_EXIST:
                $this->userNotExist();
                break;
            case InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_LOGIN_FAILED:
                $this->loginFailed();
        }

        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return InvalidLoginCommandHandlerException
     */
    private function userNotExist()
    {
        $this->setCode(InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_EXIST)
             ->setMessage(InvalidLoginCommandHandlerExceptionCode::MESSAGE_CODE_USER_NOT_EXIST);

        return $this;
    }

    /**
     * @return InvalidLoginCommandHandlerException
     */
    private function loginFailed()
    {
        $this->setCode(InvalidLoginCommandHandlerExceptionCode::STATUS_CODE_LOGIN_FAILED)
             ->setMessage(InvalidLoginCommandHandlerExceptionCode::MESSAGE_CODE_LOGIN_FAILED);

        return $this;
    }
}
