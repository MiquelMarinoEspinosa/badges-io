<?php

namespace Test\Domain\User;

use Domain\User\User;

class FakeUserBuilder extends User
{
    public static function build($id, $email, $userName, $passWord)
    {
        return new self($id, $email, $userName, $passWord);
    }
}
