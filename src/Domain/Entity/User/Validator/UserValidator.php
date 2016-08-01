<?php

namespace Domain\Entity\User\Validator;

use Domain\Entity\User\Exception\InvalidUserException;
use Domain\Entity\User\Exception\InvalidUserExceptionCode;
use Domain\Entity\User\User;
use Domain\Validator\Validator;

class UserValidator implements Validator
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
        $this->validateId()
             ->validateEmail()
             ->validateUserName()
             ->validatePassWord();
    }

    /**
     * @return UserValidator
     * @throws InvalidUserException
     */
    private function validateId()
    {
        $this->checkIdNotNull()
             ->checkIdFormat();

        return $this;
    }

    /**
     * @return UserValidator
     * @throws InvalidUserException
     */
    private function checkIdNotNull()
    {
        $aNullId = null;
        if ($aNullId === $this->user->id()) {
            throw $this->buildInvalidUserException(
                InvalidUserExceptionCode::STATUS_CODE_ID_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return UserValidator
     * @throws InvalidUserException
     */
    private function checkIdFormat()
    {
        if ($this->notValidIdFormat($this->user->id())) {
            throw $this->buildInvalidUserException(
                InvalidUserExceptionCode::STATUS_CODE_ID_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    private function notValidIdFormat($id)
    {
        return !is_string($id) || "" === trim($id);
    }

    /**
     * @return UserValidator
     * @throws InvalidUserException
     */
    private function validateEmail()
    {
        $this->checkEmailNotNull()
             ->checkEmailFormat();

        return $this;
    }

    /**
     * @return UserValidator
     * @throws InvalidUserException
     */
    private function checkEmailNotNull()
    {
        $aNullEmail = null;
        if ($aNullEmail === $this->user->email()) {
            throw $this->buildInvalidUserException(InvalidUserExceptionCode::STATUS_CODE_EMAIL_NOT_PROVIDED);
        }

        return $this;
    }

    /**
     * @return UserValidator
     * @throws InvalidUserException
     */
    private function checkEmailFormat()
    {
        if ($this->notValidEmailFormat($this->user->email())) {
            throw $this->buildInvalidUserException(
                InvalidUserExceptionCode::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED
            );
        }

        return $this;
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
     * @return UserValidator
     * @throws InvalidUserException
     */
    private function validateUserName()
    {
        $this->checkUserNameNotNull()
             ->checkUserNameFormat();

        return $this;
    }

    /**
     * @return UserValidator
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

        return $this;
    }

    /**
     * @return UserValidator
     * @throws InvalidUserException
     */
    private function checkUserNameFormat()
    {
        if ($this->notValidUserNameFormat($this->user->userName())) {
            throw $this->buildInvalidUserException(
                InvalidUserExceptionCode::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $userName
     *
     * @return bool
     */
    private function notValidUserNameFormat($userName)
    {
        return  !is_string($userName) || "" === trim($userName);
    }

    /**
     * @return UserValidator
     * @throws InvalidUserException
     */
    private function validatePassWord()
    {
        $this->validatePassWordNotNull()
             ->validatePassWordFormat();

        return $this;
    }

    /**
     * @return UserValidator
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

        return $this;
    }

    /**
     * @return UserValidator
     * @throws InvalidUserException
     */
    private function validatePassWordFormat()
    {
        if ($this->notValidPassWordFormat($this->user->passWord())) {
            throw $this->buildInvalidUserException(
                InvalidUserExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $passWord
     *
     * @return bool
     */
    private function notValidPassWordFormat($passWord)
    {
        return  !is_string($passWord) || "" === trim($passWord);
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
