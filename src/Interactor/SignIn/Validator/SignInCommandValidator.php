<?php

namespace Interactor\SignIn\Validator;

use Interactor\SignIn\Exception\InvalidSignInCommandException;
use Interactor\SignIn\SignInCommand;

class SignInCommandValidator
{
    /**
     * @var SignInCommand
     */
    private $singInCommand;

    public function __construct(SignInCommand $singInCommand)
    {
        $this->singInCommand = $singInCommand;
    }

    public function validate()
    {
        $this->validateEmail();
        $this->validateUserName();
        $this->validatePassWord();
    }

    /**
     * @throws InvalidSignInCommandException
     */
    private function validateEmail()
    {
        $this->checkEmailNotNull();
        $this->checkEmailFormat();
    }

    /**
     * @throws InvalidSignInCommandException
     */
    private function checkEmailNotNull()
    {
        $aNullEmail = null;
        if ($aNullEmail === $this->singInCommand->email()) {
            throw $this->buildInvalidCommandException(InvalidSignInCommandException::STATUS_CODE_EMAIL_NOT_PROVIDED);
        }
    }

    /**
     * @throws InvalidSignInCommandException
     */
    private function checkEmailFormat()
    {
        if ($this->notValidEmailFormat($this->singInCommand->email())) {
            throw $this->buildInvalidCommandException(
                InvalidSignInCommandException::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED
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
     * @throws InvalidSignInCommandException
     */
    private function validateUserName()
    {
        $this->checkUserNameNotNull();
        $this->checkUserNameFormat();
    }

    /**
     * @throws InvalidSignInCommandException
     */
    private function checkUserNameNotNull()
    {
        $aNullUserName = null;
        if ($aNullUserName === $this->singInCommand->userName()) {
            throw $this->buildInvalidCommandException(
                InvalidSignInCommandException::STATUS_CODE_USERNAME_NOT_PROVIDED
            );
        }
    }

    /**
     * @throws InvalidSignInCommandException
     */
    private function checkUserNameFormat()
    {
        if ($this->notValidUserNameFormat($this->singInCommand->userName())) {
            throw $this->buildInvalidCommandException(
                InvalidSignInCommandException::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED
            );
        }
    }

    private function notValidUserNameFormat($userName)
    {
        return "" === $userName;
    }

    private function validatePassWord()
    {
        $this->validatePassWordNotNull();
        $this->validatePassWordFormat();
    }

    /**
     * @throws InvalidSignInCommandException
     */
    private function validatePassWordNotNull()
    {
        $aNullPassWord = null;
        if ($aNullPassWord === $this->singInCommand->passWord()) {
            throw $this->buildInvalidCommandException(
                InvalidSignInCommandException::STATUS_CODE_PASSWORD_NOT_PROVIDED
            );
        }
    }

    /**
     * @throws InvalidSignInCommandException
     */
    private function validatePassWordFormat()
    {
        if ($this->notValidPassWordFormat($this->singInCommand->passWord())) {
            throw $this->buildInvalidCommandException(
                InvalidSignInCommandException::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED
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
     * @return InvalidSignInCommandException
     */
    private function buildInvalidCommandException($statusCode)
    {
        return new InvalidSignInCommandException($statusCode);
    }
}
