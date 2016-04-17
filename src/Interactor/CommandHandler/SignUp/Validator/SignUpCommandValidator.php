<?php

namespace Interactor\CommandHandler\SignUp\Validator;

use Interactor\CommandHandler\SignUp\Exception\InvalidSignUpCommandException;
use Interactor\CommandHandler\SignUp\Exception\InvalidSignUpCommandExceptionCode;
use Interactor\CommandHandler\SignUp\SignUpCommand;
use Interactor\Validator\Validator;

class SignUpCommandValidator implements Validator
{
    /**
     * @var SignUpCommand
     */
    private $singInCommand;

    public function __construct(SignUpCommand $singInCommand)
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
     * @return SignUpCommandValidator
     * @throws InvalidSignUpCommandException
     */
    private function validateEmail()
    {
        $this->checkEmailNotNull()
             ->checkEmailFormat();

        return $this;
    }

    /**
     * @return SignUpCommandValidator
     * @throws InvalidSignUpCommandException
     */
    private function checkEmailNotNull()
    {
        $aNullEmail = null;
        if ($aNullEmail === $this->singInCommand->email()) {
            throw $this->buildInvalidCommandException(
                InvalidSignUpCommandExceptionCode::STATUS_CODE_EMAIL_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return SignUpCommandValidator
     * @throws InvalidSignUpCommandException
     */
    private function checkEmailFormat()
    {
        if ($this->notValidEmailFormat($this->singInCommand->email())) {
            throw $this->buildInvalidCommandException(
                InvalidSignUpCommandExceptionCode::STATUS_CODE_EMAIL_NOT_VALID_PROVIDED
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
     * @return SignUpCommandValidator
     * @throws InvalidSignUpCommandException
     */
    private function validateUserName()
    {
        $this->checkUserNameNotNull()
             ->checkUserNameFormat();

        return $this;
    }

    /**
     * @return SignUpCommandValidator
     * @throws InvalidSignUpCommandException
     */
    private function checkUserNameNotNull()
    {
        $aNullUserName = null;
        if ($aNullUserName === $this->singInCommand->userName()) {
            throw $this->buildInvalidCommandException(
                InvalidSignUpCommandExceptionCode::STATUS_CODE_USERNAME_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return SignUpCommandValidator
     * @throws InvalidSignUpCommandException
     */
    private function checkUserNameFormat()
    {
        if ($this->notValidUserNameFormat($this->singInCommand->userName())) {
            throw $this->buildInvalidCommandException(
                InvalidSignUpCommandExceptionCode::STATUS_CODE_USERNAME_NOT_VALID_PROVIDED
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
     * @return SignUpCommandValidator
     * @throws InvalidSignUpCommandException
     */
    private function validatePassWord()
    {
        $this->validatePassWordNotNull()
             ->validatePassWordFormat();

        return $this;
    }

    /**
     * @return SignUpCommandValidator
     * @throws InvalidSignUpCommandException
     */
    private function validatePassWordNotNull()
    {
        $aNullPassWord = null;
        if ($aNullPassWord === $this->singInCommand->passWord()) {
            throw $this->buildInvalidCommandException(
                InvalidSignUpCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return SignUpCommandValidator
     * @throws InvalidSignUpCommandException
     */
    private function validatePassWordFormat()
    {
        if ($this->notValidPassWordFormat($this->singInCommand->passWord())) {
            throw $this->buildInvalidCommandException(
                InvalidSignUpCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED
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
     * @return InvalidSignUpCommandException
     */
    private function buildInvalidCommandException($statusCode)
    {
        return new InvalidSignUpCommandException($statusCode);
    }
}
