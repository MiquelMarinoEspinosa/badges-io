<?php

namespace Infrastructure\Resource\Api\Domain\Entity\User;

class UserApiResource
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
             ->setPassWord($passWord);
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
     * @return UserApiResource
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
     * @return UserApiResource
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
     * @return UserApiResource
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
     * @return UserApiResource
     */
    private function setPassWord($passWord)
    {
        $this->passWord = $passWord;

        return $this;
    }
}
