<?php

namespace Interactor\CommandHandler\LogIn\Validator;

use Interactor\CommandHandler\LogIn\Exception\InvalidLogInCommandException;
use Interactor\CommandHandler\LogIn\Exception\InvalidLogInCommandExceptionCode;
use Interactor\CommandHandler\LogIn\LogInCommand;
use Interactor\Validator\Validator;

class LogInCommandValidator implements Validator
{
    /**
     * @var LogInCommand
     */
    private $logInCommand;

    public function __construct(LogInCommand $logInCommand)
    {
        $this->logInCommand = $logInCommand;
    }

    public function validate()
    {
        $this->validateUserId()
             ->validatePassWord();
    }

    /**
     * @return LogInCommandValidator
     * @throws InvalidLogInCommandException
     */
    private function validateUserId()
    {
        $this->checkUserIdNotNull()
             ->checkUserIdFormat();

        return $this;
    }

    /**
     * @return LogInCommandValidator
     * @throws InvalidLogInCommandException
     */
    private function checkUserIdNotNull()
    {
        $aNullUserId = null;
        if ($this->logInCommand->userId() === $aNullUserId) {
            throw $this->buildInvalidLogInCommandException(
                InvalidLogInCommandExceptionCode::STATUS_CODE_USER_ID_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return LogInCommandValidator
     * @throws InvalidLogInCommandException
     */
    private function checkUserIdFormat()
    {
        if ($this->notValidUserIdFormat($this->logInCommand->userId())) {
            throw $this->buildInvalidLogInCommandException(
                InvalidLogInCommandExceptionCode::STATUS_CODE_USER_ID_NOT_VALID_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @param string $userId
     *
     * @return bool
     */
    private function notValidUserIdFormat($userId)
    {
        return !is_string($userId);
    }

    /**
     * @return LogInCommandValidator
     * @throws InvalidLogInCommandException
     */
    private function validatePassWord()
    {
        $this->checkPassWordNotNull()
             ->checkPassWordFormat();

        return $this;
    }

    /**
     * @return LogInCommandValidator
     * @throws InvalidLogInCommandException
     */
    private function checkPassWordNotNull()
    {
        $aNullPassWord = null;
        if ($this->logInCommand->passWord() === $aNullPassWord) {
            throw $this->buildInvalidLogInCommandException(
                InvalidLogInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_PROVIDED
            );
        }

        return $this;
    }

    /**
     * @return LogInCommandValidator
     * @throws InvalidLogInCommandException
     */
    private function checkPassWordFormat()
    {
        if ($this->notValidPassWordFormat($this->logInCommand->passWord())) {
            throw $this->buildInvalidLogInCommandException(
                InvalidLogInCommandExceptionCode::STATUS_CODE_PASSWORD_NOT_VALID_PROVIDED
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
        return !is_string($passWord);
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidLogInCommandException
     */
    private function buildInvalidLogInCommandException($statusCode)
    {
        return new InvalidLogInCommandException($statusCode);
    }
}
