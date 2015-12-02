<?php

namespace Interactor\SignIn\Exception;

use Exception\BaseException;

class InvalidSignInCommandException extends BaseException
{
    const STATUS_CODE_EMAIL_NOT_PROVIDED            = -1;
    const MESSAGE_CODE_EMAIL_NOT_PROVIDED           = 'Email not provided';
    const STATUS_CODE_EMAIL_NOT_VALID_PROVIDED      = -2;
    const MESSAGE_CODE_EMAIL_NOT_VALID_PROVIDED     = 'Email not valid provided';
    const STATUS_CODE_USERNAME_NOT_PROVIDED         = -3;
    const MESSAGE_CODE_USERNAME_NOT_PROVIDED        = 'Username not provided';
    const STATUS_CODE_USERNAME_NOT_VALID_PROVIDED   = -4;
    const MESSAGE_CODE_USERNAME_NOT_VALID_PROVIDED  = 'Username not valid provided';
    const STATUS_CODE_PASSWORD_NOT_PROVIDED         = -5;
    const MESSAGE_CODE_PASSWORD_NOT_PROVIDED        = 'Password not provided';
    const STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED   = -6;
    const MESSAGE_CODE_PASSWORD_NOT_VALID_PROVIDED  = 'Password not provided';

    public function __construct($statusCode)
    {
        switch ($statusCode) {
            case static::STATUS_CODE_EMAIL_NOT_PROVIDED:
                $this->emailNotProvided();
                break;
            case static::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED:
                $this->emailNotValidProvided();
                break;
            case static::STATUS_CODE_USERNAME_NOT_PROVIDED:
                $this->userNameNotProvided();
                break;
            case static::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED:
                $this->userNameNotValidProvided();
                break;
            case static::STATUS_CODE_PASSWORD_NOT_PROVIDED:
                $this->passWordNotProvided();
                break;
            case static::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED:
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
        $this->setCode(static::STATUS_CODE_EMAIL_NOT_PROVIDED)
             ->setMessage(static::MESSAGE_CODE_EMAIL_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignInCommandException
     */
    private function emailNotValidProvided()
    {
        $this->setCode(static::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED)
             ->setMessage(static::MESSAGE_CODE_EMAIL_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignInCommandException
     */
    private function userNameNotProvided()
    {
        $this->setCode(static::STATUS_CODE_USERNAME_NOT_PROVIDED)
             ->setMessage(static::MESSAGE_CODE_USERNAME_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignInCommandException
     */
    private function userNameNotValidProvided()
    {
        $this->setCode(static::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED)
             ->setMessage(static::MESSAGE_CODE_USERNAME_NOT_VALID_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignInCommandException
     */
    private function passWordNotProvided()
    {
        $this->setCode(static::STATUS_CODE_PASSWORD_NOT_PROVIDED)
             ->setMessage(static::MESSAGE_CODE_PASSWORD_NOT_PROVIDED);

        return $this;
    }

    /**
     * @return InvalidSignInCommandException
     */
    private function passWordNotValidProvided()
    {
        $this->setCode(static::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED)
             ->setMessage(static::MESSAGE_CODE_PASSWORD_NOT_VALID_PROVIDED);

        return $this;
    }
}
