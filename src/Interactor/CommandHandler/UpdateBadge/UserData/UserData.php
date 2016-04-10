<?php

namespace Interactor\CommandHandler\UpdateBadge\UserData;

class UserData
{
    /** @var  string */
    private $id;

    public function __construct($userId)
    {
        $this->setId($userId);
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param string $userId
     *
     * @return UserData
     */
    private function setId($userId)
    {
        $this->id = $userId;

        return $this;
    }
}
