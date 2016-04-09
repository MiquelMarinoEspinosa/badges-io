<?php

namespace Infrastructure\Services\Domain\PasswordCipher;

use Domain\Service\PasswordCipher;

class MD5PasswordCipher implements PasswordCipher
{
    /**
     * {@inheritdoc}
     */
    public function cipher($password)
    {
        return md5($password);
    }
}
