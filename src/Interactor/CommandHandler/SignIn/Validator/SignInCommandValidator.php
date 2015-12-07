<?php

namespace Interactor\CommandHandler\SignIn\Validator;

use Interactor\CommandHandler\SignIn\Exception\InvalidSignInCommandException;
use Interactor\CommandHandler\SignIn\Exception\InvalidSignInCommandExceptionCode;
use Interactor\CommandHandler\SignIn\SignInCommand;
use Interactor\Validator\Validator;

class SignInCommandValidator implements Validator
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
        $this->validateEmail()
             ->validateUserName()
             ->validatePassWord();
    }

    /**
     * @return SignInCommandValidator
     * @throws InvalidSignInCommandException
     */
    private function validateEmail()
    {
        $this->checkEmailNotNull()
             ->checkEmailFormat();

        return $this;
    }

    /**
     * @return SignInCommandValidator
     * @throws InvalidSignInCommandException
     */
    private function checkEmailNotNull()
    {
        $aNullEmail = null;
        if ($aNullEmail === $this->singInCommand->email()) {
            throw $this->buildInvalidCommandException(
                InvalidSignInCommandExceptionCode::STATUS_CODE_EMAIL_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return SignInCommandValidator
     * @throws InvalidSignInCommandException
     */
    private function checkEmailFormat()
    {
        if ($this->notValidEmailFormat($this->singInCommand->email())) {
            throw $this->buildInvalidCommandException(
                InvalidSignInCommandExceptionCode::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED
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
     * @return SignInCommandValidator
     * @throws InvalidSignInCommandException
     */
    private function validateUserName()
    {
        $this->checkUserNameNotNull()
             ->checkUserNameFormat();

        return $this;
    }

    /**
     * @return SignInCommandValidator
     * @throws InvalidSignInCommandException
     */
    private function checkUserNameNotNull()
    {
        $aNullUserName = null;
        if ($aNullUserName === $this->singInCommand->userName()) {
            throw $this->buildInvalidCommandException(
                InvalidSignInCommandExceptionCode::STATUS_CODE_USERNAME_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return SignInCommandValidator
     * @throws InvalidSignInCommandException
     */
    private function checkUserNameFormat()
    {
        if ($this->notValidUserNameFormat($this->singInCommand->userName())) {
            throw $this->buildInvalidCommandException(
                InvalidSignInCommandExceptionCode::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED
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
        return !is_string($userName) || "" === trim($userName);
    }

    /**
     * @return SignInCommandValidator
     * @throws InvalidSignInCommandException
     */
    private function validatePassWord()
    {
        $this->validatePassWordNotNull()
             ->validatePassWordFormat();

        return $this;
    }

    /**
     * @return SignInCommandValidator
     * @throws InvalidSignInCommandException
     */
    private function validatePassWordNotNull()
    {
        $aNullPassWord = null;
        if ($aNullPassWord === $this->singInCommand->passWord()) {
            throw $this->buildInvalidCommandException(
                InvalidSignInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return SignInCommandValidator
     * @throws InvalidSignInCommandException
     */
    private function validatePassWordFormat()
    {
        if ($this->notValidPassWordFormat($this->singInCommand->passWord())) {
            throw $this->buildInvalidCommandException(
                InvalidSignInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED
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
     * @return InvalidSignInCommandException
     */
    private function buildInvalidCommandException($statusCode)
    {
        return new InvalidSignInCommandException($statusCode);
    }
}
