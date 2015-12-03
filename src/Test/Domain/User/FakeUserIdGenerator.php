<?php

namespace Test\Domain\User;

use Domain\User\Service\UserIdGenerator;

class FakeUserIdGenerator implements UserIdGenerator
{
    public function generateId()
    {
        return '34214214';
    }
}
