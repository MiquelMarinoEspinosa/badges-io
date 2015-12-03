<?php

namespace Domain\User\Validator;

use Domain\User\Exception\InvalidUserException;
use Domain\User\Exception\InvalidUserExceptionCode;
use Domain\User\User;

class UserValidator
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function validate()
    {
        $this->validateId();
        $this->validateEmail();
        $this->validateUserName();
        $this->validatePassWord();
    }

    /**
     * @throws InvalidUserException
     */
    private function validateId()
    {
        $this->checkIdNotNull();
        $this->checkIdFormat();
    }

    /**
     * @throws InvalidUserException
     */
    private function checkIdNotNull()
    {
        $aNullId = null;
        if ($aNullId === $this->user->id()) {
            throw $this->buildInvalidUserException(InvalidUserExceptionCode::STATUS_CODE_ID_NOT_PROVIDED);
        }
    }

    /**
     * @throws InvalidUserException
     */
    private function checkIdFormat()
    {
        if ($this->notValidIdFormat($this->user->id())) {
            throw $this->buildInvalidUserException(
                InvalidUserExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED
            );
        }
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    private function notValidIdFormat($id)
    {
        return "" === $id;
    }

    /**
     * @throws InvalidUserException
     */
    private function validateEmail()
    {
        $this->checkEmailNotNull();
        $this->checkEmailFormat();
    }

    /**
     * @throws InvalidUserException
     */
    private function checkEmailNotNull()
    {
        $aNullEmail = null;
        if ($aNullEmail === $this->user->email()) {
            throw $this->buildInvalidUserException(InvalidUserExceptionCode::STATUS_CODE_EMAIL_NOT_PROVIDED);
        }
    }

    /**
     * @throws InvalidUserException
     */
    private function checkEmailFormat()
    {
        if ($this->notValidEmailFormat($this->user->email())) {
            throw $this->buildInvalidUserException(
                InvalidUserExceptionCode::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED
            );
        }
    }

    /**
     * @param $email
     *
     * @return bool
     */
    private function notValidEmailFormat($email)
    {
        return !filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @throws InvalidUserException
     */
    private function validateUserName()
    {
        $this->checkUserNameNotNull();
        $this->checkUserNameFormat();
    }

    /**
     * @throws InvalidUserException
     */
    private function checkUserNameNotNull()
    {
        $aNullUserName = null;
        if ($aNullUserName === $this->user->userName()) {
            throw $this->buildInvalidUserException(
                InvalidUserExceptionCode::STATUS_CODE_USERNAME_NOT_PROVIDED
            );
        }
    }

    /**
     * @throws InvalidUserException
     */
    private function checkUserNameFormat()
    {
        if ($this->notValidUserNameFormat($this->user->userName())) {
            throw $this->buildInvalidUserException(
                InvalidUserExceptionCode::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED
            );
        }
    }

    /**
     * @param string $userName
     *
     * @return bool
     */
    private function notValidUserNameFormat($userName)
    {
        return "" === $userName;
    }

    /**
     * @throws InvalidUserException
     */
    private function validatePassWord()
    {
        $this->validatePassWordNotNull();
        $this->validatePassWordFormat();
    }

    /**
     * @throws InvalidUserException
     */
    private function validatePassWordNotNull()
    {
        $aNullPassWord = null;
        if ($aNullPassWord === $this->user->passWord()) {
            throw $this->buildInvalidUserException(
                InvalidUserExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED
            );
        }
    }

    /**
     * @throws InvalidUserException
     */
    private function validatePassWordFormat()
    {
        if ($this->notValidPassWordFormat($this->user->passWord())) {
            throw $this->buildInvalidUserException(
                InvalidUserExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED
            );
        }
    }

    /**
     * @param string $passWord
     *
     * @return bool
     */
    private function notValidPassWordFormat($passWord)
    {
        return  "" === $passWord;
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidUserException
     */
    private function buildInvalidUserException($statusCode)
    {
        return new InvalidUserException($statusCode);
    }
}
