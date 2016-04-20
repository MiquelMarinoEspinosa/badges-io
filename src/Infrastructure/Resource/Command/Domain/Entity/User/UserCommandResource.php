<?php

namespace Infrastructure\Resource\Command\Domain\Entity\User;

class UserCommandResource
{
    /** @var  string */
    private $id;
    /** @var  string */
    private $email;
    /** @var  string */
    private $username;
    /** @var  string */
    private $password;

    public function __construct($id, $email, $username, $password)
    {
        $this->setId($id)
             ->setEmail($email)
             ->setUsername($username)
             ->setPassword($password);
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
     * @return UserCommandResource
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
     * @return UserCommandResource
     */
    private function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return UserCommandResource
     */
    private function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function password()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return UserCommandResource
     */
    private function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}
