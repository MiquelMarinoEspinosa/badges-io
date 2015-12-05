<?php

namespace Domain\User;

use Domain\User\Validator\UserValidator;

class User
{
    /** @var  string */
    private $id;
    /** @var  string */
    private $email;
    /** @var  string */
    private $userName;
    /** @var  string */
    private $passWord;

    public function __construct($id, $email, $userName, $passWord)
    {
        $this->setId($id)
             ->setEmail($email)
             ->setUserName($userName)
             ->setPassWord($passWord)
             ->validate();
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return User
     */
    private function setId($id)
    {
        $this->id = $id;

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
     * @param string $email
     *
     * @return User
     */
    private function setEmail($email)
    {
        $this->email = $email;

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
     * @param string $userName
     *
     * @return User
     */
    private function setUserName($userName)
    {
        $this->userName = $userName;

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
     * @param string $passWord
     *
     * @return User
     */
    private function setPassWord($passWord)
    {
        $this->passWord = $passWord;

        return $this;
    }

    /**
     * @return User
     */
    private function validate()
    {
        $this->buildValidator()->validate();

        return $this;
    }

    /**
     * @return UserValidator
     */
    private function buildValidator()
    {
        return new UserValidator($this);
    }
}
