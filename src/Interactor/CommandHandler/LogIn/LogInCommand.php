<?php

namespace Interactor\CommandHandler\LogIn;

use Interactor\CommandHandler\Command;
use Interactor\CommandHandler\LogIn\Validator\LogInCommandValidator;

class LogInCommand implements Command
{
    private $userId;
    private $passWord;

    public function __construct($userId, $passWord)
    {
        $this->setUserId($userId)
             ->setPassWord($passWord)
             ->validate();
    }

    /**
     * @return mixed
     */
    public function userId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     *
     * @return LogInCommand
     */
    private function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function passWord()
    {
        return $this->passWord;
    }

    /**
     * @param mixed $passWord
     *
     * @return LogInCommand
     */
    private function setPassWord($passWord)
    {
        $this->passWord = $passWord;

        return $this;
    }

    private function validate()
    {
        $this->buildValidator()->validate();
    }

    /**
     * @return LogInCommandValidator
     */
    private function buildValidator()
    {
        return new LogInCommandValidator($this);
    }
}
