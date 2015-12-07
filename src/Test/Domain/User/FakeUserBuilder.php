<?php

namespace Test\Domain\User;

use Domain\User\User;

class FakeUserBuilder extends User
{
    /**
     * @param string $id
     * @param string $email
     * @param string $userName
     * @param string $passWord
     *
     * @return User
     */
    public static function build($id, $email, $userName, $passWord)
    {
        return new self($id, $email, $userName, $passWord);
    }
}
