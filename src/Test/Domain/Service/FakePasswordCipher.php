<?php

namespace Test\Domain\Service;

use Domain\Service\PasswordCipher;

class FakePasswordCipher implements PasswordCipher
{

    /**
     * {@inheritdoc}
     */
    public function cipher($password)
    {
        return $password;
    }
}
