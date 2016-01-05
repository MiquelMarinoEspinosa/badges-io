<?php

namespace Interactor\CommandHandler\SignIn;

use Interactor\CommandHandler\BaseCommand;
use Interactor\CommandHandler\SignIn\Validator\SignInCommandValidator;

class SignInCommand extends BaseCommand
{
    /** @var  string */
    private $email;
    /** @var  string */
    private $userName;
    /** @var  string */
    private $passWord;

    /**
     * @param string $email
     * @param string $userName
     * @param string $passWord
     */
    public function __construct($email, $userName, $passWord)
    {
        $this->setMail($email)
             ->setUserName($userName)
             ->setPassWord($passWord)
             ->validate();
    }

    /**
     * @param string $email
     *
     * @return SignInCommand
     */
    private function setMail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @param string $userName
     *
     * @return SignInCommand
     */
    private function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @return string
     */
    public function userName()
    {
        return $this->userName;
    }

    /**
     * @param string $passWord
     *
     * @return SignInCommand
     */
    private function setPassWord($passWord)
    {
        $this->passWord = $passWord;

        return $this;
    }

    /**
     * @return string
     */
    public function passWord()
    {
        return $this->passWord;
    }

    /**
     * {@inheritdoc}
     */
    protected function buildValidator()
    {
        return new SignInCommandValidator($this);
    }
}
